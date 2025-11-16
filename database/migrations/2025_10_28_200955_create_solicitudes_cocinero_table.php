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
        Schema::create('solicitudes_cocinero', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // Datos de identificación
            $table->string('ci', 20)->unique();
            $table->string('documento_ci_path'); // Ruta a la imagen del documento
            $table->string('nombre_completo', 150);

            // Datos de ubicación
            $table->text('direccion');
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->decimal('radio_entrega_km', 5, 2)->default(5.00);

            // Datos profesionales
            $table->json('especialidades'); // ["Comida italiana", "Postres", etc.]
            $table->json('certificaciones')->nullable(); // Certificados opcionales
            $table->text('bio'); // Biografía profesional

            // Control de solicitud
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('razon_rechazo')->nullable();
            $table->timestamp('revisado_en')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            // Índices para búsquedas rápidas
            $table->index(['estado', 'created_at']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_cocinero');
    }
};
