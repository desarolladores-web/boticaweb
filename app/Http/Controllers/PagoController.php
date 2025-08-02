<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PagoController extends Controller
{




    public function pagoExitoso(Request $request)
    {
        // Aquí puedes verificar con MercadoPago si el pago realmente fue aprobado.
        $paymentId = $request->query('payment_id');

        // Simulación simple de guardar en base de datos (ajusta con tus modelos reales)
        // Solo deberías guardar si el pago fue aprobado (idealmente validando con la API)

        // Ejemplo: guardamos un registro simple de éxito
        // Pedido::create([...]);

        // Mostrar alerta en la vista principal
        Session::flash('status', 'compra_exitosa');
        return redirect()->route('/'); // o la ruta de tu vista principal
    }

    public function pagoPendiente(Request $request)
    {
        Session::flash('status', 'compra_pendiente');
        return redirect()->route('/');
    }

    public function pagoFallido(Request $request)
    {
        Session::flash('status', 'compra_fallida');
        return redirect()->route('/');
    }
}
