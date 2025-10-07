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
        Schema::create('cocineros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            $table->string('nombre_completo', 150);
            $table->string('ci', 20)->unique();
            $table->string('foto_perfil')->nullable();
            $table->text('bio')->nullable();

            $table->json('especialidades')->nullable();
            $table->json('certificaciones')->nullable();

            $table->text('direccion');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->decimal('radio_entrega_km', 5, 2)->default(5.00);

            $table->boolean('esta_disponible')->default(true);
            $table->decimal('calificacion_promedio', 3, 2)->default(0.00);
            $table->unsignedInteger('total_pedidos')->default(0);

            $table->timestamps();

            $table->index(['esta_disponible', 'calificacion_promedio']);
            $table->index(['latitud', 'longitud']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cocineros');
    }
};
