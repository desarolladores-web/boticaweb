<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\TipoDocumento;
use App\Models\Sucursal;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

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

    // 👉 Guardar datos en BD directamente (sin MercadoPago)
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

        // 👉 Registrar cliente
        $cliente = Cliente::create([
            'nombre' => $validated['nombres'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'email' => $validated['correo'],
            'tipo_documento_id' => $validated['tipo_documento_id'],
            'DNI' => $validated['numero_documento'],
            'telefono' => $validated['celular'],
        ]);

        // 👉 Calcular totales
        $subtotal = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $igv = round($subtotal * 0.18, 2);
        $total = $subtotal + $igv;

        // 👉 Registrar venta
        $venta = Venta::create([
            'cliente_id' => $cliente->id,
            'fecha' => now(),
            'igv' => $igv,
            'subtotal' => $subtotal,
            'total' => $total,
            'metodo_pago_id' => null, // Se puede asignar después
            'estado_venta_id' => 1,
        ]);

        // 👉 Registrar detalles de la venta
        foreach ($carrito as $productoId => $item) {
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $productoId,
                'cantidad' => $item['cantidad'],
                'precio_venta' => $item['precio'],
                'sucursal_id' => $validated['sucursal_id'],
                'user_id' => auth()->check() ? auth()->id() : null,
            ]);
        }
        // 👉 Reducir el stock del producto
        $producto = \App\Models\Producto::find($productoId);
        if ($producto) {
            $producto->stock = max(0, $producto->stock - $item['cantidad']);
            $producto->save();
        }

        // 👉 Limpiar carrito
        session()->forget('carrito');

        return response()->json(['mensaje' => 'Se guardaron los datos correctamente']);
    }
}
