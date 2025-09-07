<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Ventas hoy
        $ventasHoy = DB::table('ventas')
            ->whereDate('created_at', today())
            ->sum('total');

        // Clientes nuevos hoy
        $clientesNuevos = DB::table('clientes')
            ->whereDate('created_at', today())
            ->count();

        // Productos agotados (stock = 0)
        $productosAgotados = DB::table('productos')
            ->where('stock', '<=', 0)
            ->count();

        // Productos críticos (stock <= stock_min)  
        $productosCriticos = DB::table('productos')
            ->whereColumn('stock', '<=', 'stock_min')
            ->count();

        // Ventas de hoy (depende de tus tablas: ventas/detalle_ventas)
        $ventasHoy = DB::table('detalle_ventas as dv')
            ->join('ventas as v', 'dv.venta_id', '=', 'v.id')
            ->whereDate('v.created_at', Carbon::today())
            ->sum('dv.cantidad');


        // Ventas por mes (últimos 6 meses)
        $ventasMes = DB::table('ventas')
            ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('SUM(total) as total'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        // Top productos más vendidos
        $topProductos = DB::table('detalle_ventas')
            ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(detalle_ventas.cantidad) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total', 'productos.nombre');
            
            
        return view('admin.dashboard', compact(
            'ventasHoy',
            'clientesNuevos',
            'productosAgotados',
            'productosCriticos',
            
            'ventasMes',
            'topProductos'
        ));
    }
    public function productosAgotados()
    {
        $productos = DB::table('productos')
            ->select('id', 'codigo', 'nombre', 'stock', 'stock_min')
            ->get();

        return view('admin.productos_agotados', compact('productos'));
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:productos,id',
            'stock' => 'required|integer|min:0'
        ]);

        DB::table('productos')
            ->where('id', $request->id)
            ->update([
                'stock' => $request->stock,
                'updated_at' => now()
            ]);

        return redirect()
            ->route('admin.productos.agotados')
            ->with('success', '✅ Stock actualizado correctamente.');
    }
}
