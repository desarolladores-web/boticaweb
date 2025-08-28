<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Productos críticos (stock < 10 por ejemplo)
        $productosCriticos = DB::table('productos')
            ->where('stock', '<', 10)
            ->count();

        // Reclamos pendientes
        $reclamosPendientes = DB::table('reclamos')
            ->where('estado', 'Pendiente')
            ->count();

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

        // Métodos de pago
        $metodosPago = DB::table('ventas')
            ->join('metodo_pagos', 'ventas.metodo_pago_id', '=', 'metodo_pagos.id')
            ->select('metodo_pagos.nombre as metodo_pago', DB::raw('COUNT(*) as total'))
            ->groupBy('metodo_pagos.nombre')
            ->pluck('total', 'metodo_pago');
        // Reclamos por estado
        $reclamosEstado = DB::table('reclamos')
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        return view('admin.dashboard', compact(
            'ventasHoy',
            'clientesNuevos',
            'productosCriticos',
            'reclamosPendientes',
            'ventasMes',
            'topProductos',
            'metodosPago',
            'reclamosEstado'
        ));
    }
}
