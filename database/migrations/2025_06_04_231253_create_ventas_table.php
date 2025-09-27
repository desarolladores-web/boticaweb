<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('tipo_comprobante', 100)->nullable();
            $table->float('igv')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('total')->nullable();
            $table->unsignedBigInteger('metodo_pago_id')->nullable();
            $table->unsignedBigInteger('estado_venta_id')->nullable();

            // Nuevo campo para comprobante de pago (ej. Yape)
            $table->string('imagen_comprobante')->nullable();

            // Campos MercadoPago
            $table->string('mp_payment_id')->nullable(); // ID del pago en MP
            $table->string('mp_status')->nullable(); // Estado del pago en MP
            $table->string('mp_merchant_order_id')->nullable(); // Orden merchant MP
            $table->string('mp_preference_id')->nullable(); // preference_id para seguimiento

            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
            $table->foreign('metodo_pago_id')->references('id')->on('metodo_pagos')->onDelete('set null');
            $table->foreign('estado_venta_id')->references('id')->on('estado_ventas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
