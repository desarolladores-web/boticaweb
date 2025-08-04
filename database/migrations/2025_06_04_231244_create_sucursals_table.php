<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
                'nombre' => 'Sucursal TINGUIÑA',
                'direccion' => 'CALLE. CARACAS N° 498 MZ° 36 LT° 01 TINGUIÑA - ZONA C',
                'ubicacion_exacta' => 'Alfrente de la plaza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Sucursal TINGUIÑA 2',
                'direccion' => 'CALLE. PARIS N° 825 MZ.26A LT. 09 C.P LA TINGUIÑA - ZONA C',
                'ubicacion_exacta' => '#',
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
