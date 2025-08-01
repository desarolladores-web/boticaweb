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
        // Tabla users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_documento_id')->nullable(); //duplicados por las huevas jaja
            $table->unsignedBigInteger('rol_id')->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100)->nullable();
            $table->boolean('estado')->default(true);
            $table->dateTime('fecha_ingreso')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->binary('imagen')->nullable(); // 👈 Campo binario para imagen
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos')->onDelete('set null');
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('set null');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
       
        });
            

        // Tabla sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
      DB::statement('ALTER TABLE users MODIFY imagen LONGBLOB NULL');
};
