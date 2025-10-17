<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversacion_id')->constrained('conversaciones')->onDelete('cascade');
            $table->foreignId('remitente_id')->constrained('users')->onDelete('cascade');

            $table->text('mensaje');
            $table->enum('tipo', ['texto', 'imagen', 'sistema'])->default('texto');
            $table->boolean('leido')->default(false);

            $table->timestamp('created_at');

            $table->index(['conversacion_id', 'created_at']);
            $table->index('remitente_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
