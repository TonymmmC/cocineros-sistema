<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('direcciones_cliente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            $table->string('alias', 50);
            $table->text('direccion_completa');
            $table->text('referencia')->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->boolean('es_principal')->default(false);

            $table->timestamps();

            $table->index('cliente_id');
            $table->index('es_principal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones_cliente');
    }
};
