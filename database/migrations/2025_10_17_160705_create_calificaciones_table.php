<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->unique()->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('cocinero_id')->constrained('cocineros')->onDelete('cascade');

            $table->unsignedTinyInteger('puntuacion');
            $table->text('comentario')->nullable();
            $table->json('fotos')->nullable();

            $table->text('respuesta_cocinero')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->boolean('es_visible')->default(true);

            $table->timestamps();

            $table->index(['cocinero_id', 'puntuacion']);
            $table->index('es_visible');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
