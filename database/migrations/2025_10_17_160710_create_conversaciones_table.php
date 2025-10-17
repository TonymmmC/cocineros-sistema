<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->unique()->constrained('pedidos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('cocinero_id')->constrained('cocineros')->onDelete('cascade');

            $table->timestamp('ultima_actividad')->useCurrent();
            $table->timestamp('created_at');

            $table->index(['cliente_id', 'ultima_actividad']);
            $table->index(['cocinero_id', 'ultima_actividad']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversaciones');
    }
};
