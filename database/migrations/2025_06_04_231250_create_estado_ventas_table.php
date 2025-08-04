<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estado_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('estado', 50)->nullable();
            $table->timestamps();
        });

        // Insertar los estados después de crear la tabla
        DB::table('estado_ventas')->insert([
            [
                'estado' => 'venta pendiente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'estado' => 'venta entregada',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_ventas');
    }
};
