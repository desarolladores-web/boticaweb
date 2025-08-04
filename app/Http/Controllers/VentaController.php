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

    

    public function marcarComoEntregada($id)
{
    $venta = Venta::findOrFail($id);
    $venta->estado_venta_id = 2; // Asegúrate que 2 es el ID de "entregada" en tu tabla estado_ventas
    $venta->save();

    return redirect()->route('admin.ventas.pendientes')->with('success', 'Venta marcada como entregada.');
}



public function ventasEntregadas()
{
    $ventas = Venta::where('estado_venta_id', 2)->with('cliente')->get(); // Asegúrate que 2 sea 'entregada'
    return view('admin.ventas.entregadas', compact('ventas'));
}

}
