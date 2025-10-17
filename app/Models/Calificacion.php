<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'pedido_id',
        'cliente_id',
        'cocinero_id',
        'puntuacion',
        'comentario',
        'fotos',
        'respuesta_cocinero',
        'fecha_respuesta',
        'es_visible',
    ];

    protected $casts = [
        'fotos' => 'array',
        'fecha_respuesta' => 'datetime',
        'es_visible' => 'boolean',
        'puntuacion' => 'integer',
    ];

    protected static function booted(): void
    {
        static::created(function (Calificacion $calificacion) {
            $calificacion->actualizarPromedioCocinero();
        });

        static::updated(function (Calificacion $calificacion) {
            if ($calificacion->isDirty('puntuacion')) {
                $calificacion->actualizarPromedioCocinero();
            }
        });

        static::deleted(function (Calificacion $calificacion) {
            $calificacion->actualizarPromedioCocinero();
        });
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cocinero(): BelongsTo
    {
        return $this->belongsTo(Cocinero::class);
    }

    public function responder(string $respuesta): void
    {
        $this->update([
            'respuesta_cocinero' => $respuesta,
            'fecha_respuesta' => now(),
        ]);
    }

    protected function actualizarPromedioCocinero(): void
    {
        $promedio = self::where('cocinero_id', $this->cocinero_id)
            ->where('es_visible', true)
            ->avg('puntuacion');

        $this->cocinero->update([
            'calificacion_promedio' => round($promedio, 2),
        ]);
    }

    public function scopeVisibles($query)
    {
        return $query->where('es_visible', true);
    }

    public function scopeConRespuesta($query)
    {
        return $query->whereNotNull('respuesta_cocinero');
    }

    public function scopeSinRespuesta($query)
    {
        return $query->whereNull('respuesta_cocinero');
    }
}

// REFACTOR SUGGESTIONS:
// 1. Validar rango de puntuación (1-5) en el modelo
// 2. Agregar método para moderar calificaciones (admin)
// 3. Implementar sistema de reportes para comentarios inapropiados
