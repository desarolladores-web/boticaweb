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

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] += $request->input('cantidad', 1);
        } else {
            $carrito[$id] = [
                "id" => $producto->id, // ✅ Esto es lo que falta
                "nombre" => $producto->nombre,
                "cantidad" => $request->input('cantidad', 1),
                "precio" => $producto->pvp1,
                "imagen" => $producto->imagen ? 'data:image/jpeg;base64,' . base64_encode($producto->imagen) : null,
                "presentacion" => optional($producto->presentacion)->tipo_presentacion ?? '—'
            ];
        }


        session()->put('carrito', $carrito);

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

        $redirect = $request->input('redirect_back', url()->previous());
        $desdeSidebar = $request->input('desde_sidebar', false);

        $response = redirect($redirect)->with('success', 'Producto eliminado del carrito');

        if ($desdeSidebar) {
            $response->with('abrir_sidebar', true);
        }

        return $response;
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

        $redirect = $request->input('redirect_back', url()->previous());
        $desdeSidebar = $request->input('desde_sidebar', false);

        $response = redirect($redirect);

        if ($desdeSidebar) {
            $response->with('abrir_sidebar', true);
        }

        return $response;
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
}
