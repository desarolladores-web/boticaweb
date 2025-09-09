<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\TipoDocumento;
use App\Models\Sucursal;
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

    public function guardarDatosYRedirigir(Request $request)
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

        // Guardamos los datos en sesión para usarlos al confirmar el pago
        session([
            'checkout_cliente' => $validated,
            'checkout_carrito' => $carrito
        ]);

        // Calcular subtotal y comisión
        $subtotal = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $comision = round(($subtotal * 0.0399) + 1, 2);
        $total = $subtotal + $comision;

        // Crear preferencia de MercadoPago
        SDK::setAccessToken(config('services.mercadopago.token'));

        $items = [];
        foreach ($carrito as $itemCarrito) {
            $item = new Item();
            $item->title = $itemCarrito['nombre'] ?? 'Producto';
            $item->quantity = (int) $itemCarrito['cantidad'];
            $item->unit_price = (float) $itemCarrito['precio'];
            $items[] = $item;
        }

        $preference = new Preference();
        $preference->items = $items;

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
        $preference->payer = $payer;

        $preference->back_urls = [
            'success' => route('checkout.success'),
            'failure' => route('checkout.failure'),
            'pending' => route('checkout.pending'),
        ];
        $preference->auto_return = 'approved';
        $preference->save();

        return response()->json(['init_point' => $preference->init_point]);
    }

    public function success(Request $request)
    {
        $clienteData = session('checkout_cliente');
        $carrito = session('checkout_carrito', []);

        if (!$clienteData || empty($carrito)) {
            return redirect()->route('welcome')->with('error', 'No se encontraron datos del pedido.');
        }

        // Crear o recuperar cliente
        $user = auth()->user();
        if ($user && $user->cliente_id) {
            $cliente_id = $user->cliente_id;
        } else {
            $cliente = Cliente::create([
                'nombre' => $clienteData['nombres'],
                'apellido_paterno' => $clienteData['apellido_paterno'],
                'apellido_materno' => $clienteData['apellido_materno'],
                'email' => $clienteData['correo'],
                'tipo_documento_id' => $clienteData['tipo_documento_id'],
                'DNI' => $clienteData['numero_documento'],
                'telefono' => $clienteData['celular'],
            ]);
            $cliente_id = $cliente->id;
        }

        // Calcular totales
        $subtotal = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $comision = round(($subtotal * 0.0399) + 1, 2);
        $total = $subtotal + $comision;

        // Guardar venta
        $venta = Venta::create([
            'cliente_id' => $cliente_id,
            'fecha' => now(),
            'igv' => $comision,
            'subtotal' => $subtotal,
            'total' => $total,
            'metodo_pago_id' => null,
            'estado_venta_id' => 1,
        ]);

        // Guardar detalles
        foreach ($carrito as $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'precio_venta' => $item['precio'],
                'sucursal_id' => $clienteData['sucursal_id'],
                'user_id' => auth()->check() ? auth()->id() : null,
            ]);

            $producto = \App\Models\Producto::find($item['id']);
            if ($producto) {
                $producto->stock = max(0, $producto->stock - $item['cantidad']);
                $producto->save();
            }
        }

        // Limpiar sesiones
        session()->forget(['checkout_cliente', 'checkout_carrito', 'carrito']);

        return redirect()->route('welcome')->with('success', '¡Compra realizada con éxito!');
    }

    public function failure()
    {
        session()->forget(['checkout_cliente', 'checkout_carrito']);
        return redirect()->route('welcome')->with('error', 'El pago no se completó.');
    }

    public function pending()
    {
        return redirect()->route('welcome')->with('warning', 'El pago está pendiente de confirmación.');
    }
}
