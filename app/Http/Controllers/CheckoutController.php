<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\TipoDocumento;
use App\Models\Sucursal;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use MercadoPago\Payer;

class CheckoutController extends Controller
{
    public function mostrarCheckout()
    {
        $sucursales = Sucursal::all();
        $tiposDocumento = TipoDocumento::all();
        $carrito = session('carrito', []);

        $total = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);

        return view('venta.checkout', compact('sucursales', 'tiposDocumento', 'carrito', 'total'));
    }

    // 🔹 Paso 1: Crear preferencia de Mercado Pago
    public function crearPreferencia(Request $request)
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return response()->json(['error' => 'El carrito está vacío.'], 400);
        }

        try {
            $validated = $request->validate([
                'nombres' => 'required|string',
                'apellido_paterno' => 'required|string',
                'apellido_materno' => 'required|string',
                'correo' => 'required|email',
                'tipo_documento_id' => 'required|integer',
                'numero_documento' => 'required',
                'celular' => 'required',
                'sucursal_id' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }

        // Guardamos temporalmente datos en sesión para usarlos después
        session([
            'checkout_datos' => $validated,
            'checkout_carrito' => $carrito
        ]);

        // Calcular subtotal y comisión
        $subtotal = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $comision = round(($subtotal * 0.0399) + 1, 2);
        $total = $subtotal + $comision;

        // Configurar SDK
        SDK::setAccessToken(config('services.mercadopago.token'));

        $items = [];
        $count = count($carrito);
        $assigned_total = 0.0;
        $i = 0;

        foreach ($carrito as $itemCarrito) {
            $i++;
            $quantity = (int) $itemCarrito['cantidad'];
            $lineTotal = $itemCarrito['precio'] * $quantity;

            $lineCommission = ($subtotal > 0) ? ($lineTotal / $subtotal) * $comision : 0;

            if ($i < $count) {
                $lineWithCommission = round($lineTotal + $lineCommission, 2);
                $unit_price = round($lineWithCommission / $quantity, 2);
                $assigned_total += $unit_price * $quantity;
            } else {
                $remaining_total = round($total - $assigned_total, 2);
                if ($remaining_total <= 0) {
                    $lineWithCommission = round($lineTotal + $lineCommission, 2);
                    $unit_price = round($lineWithCommission / $quantity, 2);
                } else {
                    $unit_price = round($remaining_total / $quantity, 2);
                }
            }

            $item = new Item();
            $item->title = $itemCarrito['nombre'] ?? 'Producto';
            $item->quantity = $quantity;
            $item->unit_price = (float) $unit_price;
            $items[] = $item;
        }

        $preference = new Preference();
        $preference->items = $items;

        // Datos del comprador
        $payer = new Payer();
        $payer->name = $validated['nombres'];
        $payer->surname = $validated['apellido_paterno'] . ' ' . $validated['apellido_materno'];
        $payer->email = $validated['correo'];
        $payer->identification = [
            'type' => 'DNI',
            'number' => $validated['numero_documento']
        ];
        $payer->phone = [
            'area_code' => '51',
            'number' => $validated['celular']
        ];
        $payer->address = [
            'street_name' => 'Dirección no especificada',
            'street_number' => 0
        ];
        $preference->payer = $payer;

        // URLs de retorno
        $preference->back_urls = [
            'success' => route('checkout.procesarPago', ['status' => 'approved']),
            'failure' => route('checkout.procesarPago', ['status' => 'failure']),
            'pending' => route('checkout.procesarPago', ['status' => 'pending']),
        ];

        $preference->auto_return = 'approved';
        $preference->save();

        return response()->json(['init_point' => $preference->init_point]);
    }

    // 🔹 Paso 2: Confirmar pago y guardar en BD
    public function procesarPago(Request $request)
    {
        $status = $request->query('status'); // approved / failure / pending

        if ($status !== 'approved') {
            return redirect()->route('welcome')->with('error', 'El pago no fue aprobado.');
        }

        $validated = session('checkout_datos');
        $carrito = session('checkout_carrito', []);

        if (!$validated || empty($carrito)) {
            return redirect()->route('welcome')->with('error', 'Datos de checkout no encontrados.');
        }

        // Crear cliente si no existe
        $user = auth()->user();
        if ($user && $user->cliente_id) {
            $cliente_id = $user->cliente_id;
        } else {
            $cliente = Cliente::create([
                'nombre' => $validated['nombres'],
                'apellido_paterno' => $validated['apellido_paterno'],
                'apellido_materno' => $validated['apellido_materno'],
                'email' => $validated['correo'],
                'tipo_documento_id' => $validated['tipo_documento_id'],
                'DNI' => $validated['numero_documento'],
                'telefono' => $validated['celular'],
            ]);
            $cliente_id = $cliente->id;
        }

        // Calcular subtotal y comisión
        $subtotal = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $comision = round(($subtotal * 0.0399) + 1, 2);
        $total = $subtotal + $comision;

        // Crear venta
        $venta = Venta::create([
            'cliente_id' => $cliente_id,
            'fecha' => now(),
            'igv' => $comision,
            'subtotal' => $subtotal,
            'total' => $total,
            'metodo_pago_id' => null,
            'estado_venta_id' => 1,
        ]);

        // Crear detalle de venta
        foreach ($carrito as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'precio_venta' => $item['precio'],
                'sucursal_id' => $validated['sucursal_id'],
                'user_id' => auth()->check() ? auth()->id() : null,
            ]);

            // Reducir stock
            $producto = Producto::find($item['id']);
            if ($producto) {
                $producto->stock = max(0, $producto->stock - $item['cantidad']);
                $producto->save();
            }
        }

        // Limpiar sesión
        session()->forget(['carrito', 'checkout_datos', 'checkout_carrito']);

        return redirect()->route('welcome')->with('success', 'Pago confirmado y venta registrada correctamente.');
    }
}
