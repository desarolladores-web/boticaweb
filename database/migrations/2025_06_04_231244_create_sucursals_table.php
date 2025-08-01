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
        Schema::create('sucursals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->text('ubicacion_exacta')->nullable();
            $table->timestamps();
        });

        DB::table('sucursals')->insert([
            [
                'nombre' => 'Sucursal Centro',
                'direccion' => 'Av. Principal 123 - Centro',
                'ubicacion_exacta' => 'Frente al parque central',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sucursal Norte',
                'direccion' => 'Calle Norte 456 - Distrito Norte',
                'ubicacion_exacta' => 'A una cuadra del hospital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursals');
    }
};
