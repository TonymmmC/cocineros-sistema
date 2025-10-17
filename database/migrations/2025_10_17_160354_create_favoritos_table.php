<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
            $table->foreignId('cocinero_id')->nullable()->constrained('cocineros')->onDelete('cascade');

            $table->timestamp('created_at');

            $table->index('cliente_id');
            $table->index('producto_id');
            $table->index('cocinero_id');

            $table->unique(['cliente_id', 'producto_id']);
            $table->unique(['cliente_id', 'cocinero_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
