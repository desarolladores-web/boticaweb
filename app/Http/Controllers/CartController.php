<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CartController extends Controller
{
  public function agregar(Request $request, $id)
{
    $producto = Producto::findOrFail($id);
    $carrito = session()->get('carrito', []);
    $cantidad = (int) $request->input('cantidad', 1);

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad'] += $cantidad;
    } else {
        $carrito[$id] = [
            "id" => $producto->id,
            "nombre" => $producto->nombre,
            "cantidad" => $cantidad,
            "precio" => $producto->pvp1,
            "imagen" => $producto->imagen ? 'data:image/jpeg;base64,' . base64_encode($producto->imagen) : null,
            "presentacion" => optional($producto->presentacion)->tipo_presentacion ?? '—'
        ];
    }

    session()->put('carrito', $carrito);

    if ($request->ajax()) {
       return response()->json([
    'success' => true,
    'message' => 'Producto agregado al carrito',
    'cantidadTotal' => count($carrito)
]);
    }

    return redirect()->back()->with('success', 'Producto agregado al carrito');
}



    public function mostrar()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.sidebar', compact('carrito'));
    }

   public function eliminar(Request $request, $id)
{
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        unset($carrito[$id]);
        session()->put('carrito', $carrito);
    }

    // Calcular nuevo total después de eliminar
    $total = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    // Renderizar HTML actualizado del sidebar
    $sidebarHtml = view('components.cart-items', compact('carrito'))->render();

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'mensaje' => 'Producto eliminado del carrito',
            'cantidadTotal' => count($carrito),
            'carrito' => $carrito,
            'ruta_carrito' => route('carrito.ver'),
            'total' => $total,
            'sidebar_html' => $sidebarHtml, // <-- agregar aquí
        ]);
    }

    $redirect = $request->input('redirect_back', url()->previous());
    return redirect($redirect)->with('success', 'Producto eliminado del carrito');
}








public function actualizar(Request $request, $id)
{
    $tipo = $request->input('tipo');
    $carrito = session()->get('carrito', []);

    if (isset($carrito[$id])) {
        if ($tipo === 'sumar') {
            $carrito[$id]['cantidad'] += 1;
        } elseif ($tipo === 'restar' && $carrito[$id]['cantidad'] > 1) {
            $carrito[$id]['cantidad'] -= 1;
        }
        session()->put('carrito', $carrito);
    }

    // Calcular totales
    $total = 0;
    $totalItems = 0;
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
        $totalItems += $item['cantidad'];
    }

    // Calcular subtotal producto actualizado
    $subtotalProducto = isset($carrito[$id]) ? $carrito[$id]['precio'] * $carrito[$id]['cantidad'] : 0;

    // Siempre devolver JSON si es AJAX
    if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
        return response()->json([
            'success' => true,
            'mensaje' => 'Cantidad actualizada',
            'producto_id' => $id,
            'cantidad' => $carrito[$id]['cantidad'] ?? 0,
            'subtotal' => $subtotalProducto,    // agregado subtotal
            'total' => $total,                  // enviar sin number_format
            'totalItems' => $totalItems,
            'cantidadTotal' => count($carrito)
        ]);
    }

    // Si no es AJAX, redirigir (caso excepcional)
    return redirect()->back();
}






    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('carrito.vercarrito', compact('carrito', 'total'));
    }
   public function obtenerSidebarAjax()
{
    $carrito = session('carrito', []);
    $total = 0;

    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }

    $itemsView = view('components.cart-items', compact('carrito'))->render();

    return response()->json([
        'items_html' => $itemsView,
        'total' => number_format($total, 2)
    ]);
}



}
