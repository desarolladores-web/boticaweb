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
        Schema::create('compras', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('proveedor_id')->nullable();
    $table->dateTime('fecha')->nullable();
    $table->decimal('total', 10, 2)->nullable();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->timestamps();

    $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('set null');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
