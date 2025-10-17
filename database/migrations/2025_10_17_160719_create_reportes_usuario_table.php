<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reportador_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reportado_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');

            $table->string('motivo', 100);
            $table->text('descripcion');

            $table->enum('estado', ['pendiente', 'en_revision', 'resuelto', 'rechazado'])->default('pendiente');
            $table->text('accion_tomada')->nullable();

            $table->timestamps();

            $table->index(['reportado_id', 'estado']);
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes_usuario');
    }
};
