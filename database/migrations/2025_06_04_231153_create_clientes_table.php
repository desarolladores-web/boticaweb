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
        Schema::create('clientes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre', 100)->nullable();
    $table->string('DNI', 15)->nullable();
    $table->string('apellido_paterno', 100)->nullable();
    $table->string('apellido_materno', 100)->nullable();
    $table->string('direccion', 100)->nullable();
    $table->string('telefono', 100)->nullable();
    $table->string('email', 100)->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
