<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Venta;


class VentaController extends Controller

{
    public function pendientes()
    {
        $ventas = Venta::with(['cliente.tipoDocumento', 'detalleVentas.producto', 'estadoVenta'])
            ->where('estado_venta_id', 1) // Ventas "para entregar"
            ->orderByDesc('fecha')
            ->paginate(10);

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
        $ventas = Venta::where('estado_venta_id', 2)
            ->with('cliente')
            ->orderByDesc('fecha')
            ->paginate(10); // ✅ para que también funcione links()

        return view('admin.ventas.entregadas', compact('ventas'));
    }
}
