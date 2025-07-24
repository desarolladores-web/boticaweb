<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Solo traer 8 productos con su relación de presentación
        $productos = Producto::with('presentacion')->take(8)->get();

        $carrito = session('carrito', []); // Mantener el carrito de sesión

        return view('welcome', compact('productos', 'carrito'));
    }
}
