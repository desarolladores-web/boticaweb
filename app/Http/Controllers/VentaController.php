<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Venta;


class VentaController extends Controller

{
    public function pendientes(Request $request)
    {
        $query = Venta::with(['cliente.tipoDocumento', 'detalleVentas.producto', 'estadoVenta'])
            ->where('estado_venta_id', 1); // Ventas "para entregar"

        // 🔍 Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = trim($request->buscar);

            // separar en palabras (ejemplo: "Juan Pérez" => ["Juan", "Pérez"])
            $palabras = explode(' ', $buscar);

            $query->whereHas('cliente', function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where(function ($sub) use ($palabra) {
                        $sub->where('DNI', 'like', "%{$palabra}%")
                            ->orWhere('nombre', 'like', "%{$palabra}%")
                            ->orWhere('apellido_paterno', 'like', "%{$palabra}%")
                            ->orWhere('apellido_materno', 'like', "%{$palabra}%");
                    });
                }
            });
        }

        $ventas = $query->orderByDesc('fecha')->paginate(10);

        return view('admin.ventas.index', compact('ventas'));
    }





    public function marcarComoEntregada($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->estado_venta_id = 2; // Asegúrate que 2 es el ID de "entregada" en tu tabla estado_ventas
        $venta->save();

        return redirect()->route('admin.ventas.pendientes')->with('success', 'Venta marcada como entregada.');
    }



    public function ventasEntregadas(Request $request)
    {
        $buscar = $request->input('buscar');

        $ventas = Venta::where('estado_venta_id', 2)
            ->with(['cliente', 'detalleVentas.producto', 'estadoVenta'])
            ->when($buscar, function ($query, $buscar) {
                $query->whereHas('cliente', function ($q) use ($buscar) {
                    $q->where('DNI', 'like', "%{$buscar}%")
                        ->orWhere('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido_paterno', 'like', "%{$buscar}%")
                        ->orWhere('apellido_materno', 'like', "%{$buscar}%");
                });
            })
            ->orderByDesc('fecha')
            ->paginate(10);

        return view('admin.ventas.entregadas', compact('ventas'));
    }
}
