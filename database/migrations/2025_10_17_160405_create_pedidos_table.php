<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_pedido', 20)->unique();

            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->foreignId('cocinero_id')->constrained('cocineros')->onDelete('restrict');
            $table->foreignId('direccion_id')->constrained('direcciones_cliente')->onDelete('restrict');

            $table->enum('estado', [
                'pendiente',
                'confirmado',
                'preparando',
                'listo',
                'en_camino',
                'entregado',
                'cancelado'
            ])->default('pendiente');

            $table->decimal('subtotal', 10, 2);
            $table->decimal('comision_plataforma', 10, 2)->default(0);
            $table->decimal('costo_entrega', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->enum('metodo_pago', ['qr', 'tarjeta', 'efectivo'])->default('efectivo');
            $table->enum('estado_pago', ['pendiente', 'pagado', 'reembolsado'])->default('pendiente');

            $table->text('notas_cliente')->nullable();
            $table->unsignedSmallInteger('tiempo_estimado_min')->nullable();

            $table->timestamp('fecha_confirmacion')->nullable();
            $table->timestamp('fecha_listo')->nullable();
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamp('fecha_cancelacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();

            $table->timestamps();

            $table->index(['cliente_id', 'estado']);
            $table->index(['cocinero_id', 'estado']);
            $table->index('codigo_pedido');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
