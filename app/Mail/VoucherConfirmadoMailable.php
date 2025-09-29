<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VoucherConfirmadoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $venta;
    public $path;

    public function __construct($venta, $path)
    {
        $this->venta = $venta;
        $this->path = $path;
    }

    public function build()
    {
        return $this->subject('Confirmación de Compra - Botica Mirian')
            ->view('emails.voucher_confirmado')
            ->attach(storage_path('app/public/' . $this->path));
    }
}
