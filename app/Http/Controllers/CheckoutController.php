<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class CheckoutController extends Controller
{
    public function iniciarPago()
    {
        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        try {
            // Configurar MercadoPago
            MercadoPagoConfig::setAccessToken('APP_USR-6033445216607702-072403-a0022df6e0a245763db56094498c00ae-1686393409');

            $preferenceClient = new PreferenceClient();

            // Preparar items
            $items = [];
            foreach ($carrito as $id => $item) {
                $items[] = [
                    "title" => $item['nombre'],
                    "quantity" => (int) $item['cantidad'],
                    "unit_price" => (float) $item['precio'],
                    "currency_id" => "PEN"
                ];
            }

            // Crear preferencia
            $preference = $preferenceClient->create([
                "items" => $items,
                "back_urls" => [
                    "success" => route('checkout.exito'),
                    "failure" => route('checkout.fallo'),
                    "pending" => route('checkout.pendiente'),
                ],
            ]);

            return redirect($preference->init_point);
        } catch (\Exception $e) {
            Log::error('Error al crear preferencia de MercadoPago: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al iniciar el pago. Inténtalo nuevamente.');
        }
    }

    // 👉 Cuando el pago es exitoso
    public function pagoExitoso()
    {
        session()->forget('carrito');
        return redirect()->route('welcome')->with('status', 'compra_exitosa');
    }

    // 👉 Cuando el pago falla
    public function pagoFallido()
    {
        return redirect()->route('welcome')->with('status', 'compra_fallida');
    }

    // 👉 Cuando el pago está pendiente
    public function pagoPendiente()
    {
        return redirect()->route('welcome')->with('status', 'compra_pendiente');
    }
}
