<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');  // Asegura que el usuario esté autenticado
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Verificar si el usuario está autenticado
        $cliente = Auth::check() ? Auth::user()->cliente : null;

        // Pasar la variable $cliente a la vista
        return view('home', compact('cliente'));  // Pasa la variable 'cliente' a la vista 'home'
    }
}

