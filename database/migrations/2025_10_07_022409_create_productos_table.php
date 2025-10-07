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
            $table->foreignId('cocinero_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');

            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->unsignedSmallInteger('tiempo_preparacion_min')->default(30);

            $table->json('imagenes')->nullable();
            $table->json('ingredientes')->nullable();
            $table->json('alergenos')->nullable();

            $table->unsignedSmallInteger('porciones')->default(1);
            $table->boolean('disponible')->default(true);
            $table->unsignedInteger('stock_disponible')->nullable();

            $table->boolean('es_vegetariano')->default(false);
            $table->boolean('es_vegano')->default(false);
            $table->boolean('es_sin_gluten')->default(false);

            $table->unsignedBigInteger('vistas')->default(0);

            $table->timestamps();

            $table->index(['categoria_id', 'disponible']);
            $table->index(['cocinero_id', 'disponible']);
            $table->index('precio');
            $table->fullText(['nombre', 'descripcion']);
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
