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
        Schema::create('tipo_documentos', function (Blueprint $table) {
    $table->id();
    $table->string('nombre_documento', 50)->nullable();
    $table->timestamps();
});

DB::table('tipo_documentos')->insert([
    ['nombre_documento' => 'DNI', 'created_at' => now(), 'updated_at' => now()],
    ['nombre_documento' => 'Carnet de extranjería', 'created_at' => now(), 'updated_at' => now()],
]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_documentos');
    }
};
