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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 50)->nullable(); // Código del producto
            $table->string('nombre', 100)->nullable(); // Nombre comercial
            $table->text('descripcion')->nullable();
            $table->string('principio_activo', 150)->nullable(); // Prin A (principio activo)


            $table->decimal('pvp1', 10, 2)->nullable()->comment('Precio de venta principal'); // PVP1 = precio_venta

            $table->decimal('precio_costo_unitario', 10, 2)->nullable(); // Costo por unidad


            $table->integer('stock')->nullable();
            $table->integer('stock_min')->nullable()->comment('Stock mínimo para alerta'); // Para alertas de bajo stock


            $table->date('fecha_vencimiento')->nullable(); // Fecha de vencimiento

           
            $table->binary('imagen')->nullable(); // 👈 Campo binario para imagen

            // Relaciones con claves foráneas
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('laboratorio_id')->nullable();
            $table->unsignedBigInteger('presentacion_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios')->onDelete('set null');
            $table->foreign('presentacion_id')->references('id')->on('presentacions')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
