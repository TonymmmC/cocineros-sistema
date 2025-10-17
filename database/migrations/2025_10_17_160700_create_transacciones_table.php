<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('restrict');

            $table->enum('tipo', ['pago_cliente', 'pago_cocinero', 'comision', 'reembolso']);
            $table->decimal('monto', 10, 2);
            $table->enum('metodo', ['qr', 'tarjeta', 'efectivo', 'transferencia']);
            $table->enum('estado', ['pendiente', 'completada', 'fallida', 'reembolsada'])->default('pendiente');

            $table->string('referencia_externa')->nullable();
            $table->json('detalles')->nullable();

            $table->timestamps();

            $table->index(['pedido_id', 'tipo']);
            $table->index('estado');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacciones');
    }
};
