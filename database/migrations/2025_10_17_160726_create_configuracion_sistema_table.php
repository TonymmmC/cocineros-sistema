<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 100)->unique();
            $table->text('valor');
            $table->enum('tipo', ['texto', 'numero', 'booleano', 'json'])->default('texto');
            $table->text('descripcion')->nullable();

            $table->timestamp('updated_at');

            $table->index('clave');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
