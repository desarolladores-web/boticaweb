<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Venta;


class VentaController extends Controller

{
    public function pendientes()
    {
        $ventas = Venta::with('cliente', 'estadoVenta')
            ->where('estado_venta_id', 1) // Solo ventas "para entregar"
            ->orderByDesc('fecha')
            ->get();

        return view('admin.ventas.index', compact('ventas'));
    }

    public function entregadas()
    {
        $ventas = \App\Models\Venta::with('cliente', 'estadoVenta')
            ->where('estado_venta_id', 2) // Ventas entregadas
            ->orderByDesc('fecha')
            ->get();

        return view('admin.ventas.entregadas', compact('ventas'));
    }
}
