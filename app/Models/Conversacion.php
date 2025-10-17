<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversacion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'conversaciones';

    protected $fillable = [
        'pedido_id',
        'cliente_id',
        'cocinero_id',
        'ultima_actividad',
    ];

    protected $casts = [
        'ultima_actividad' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Conversacion $conversacion) {
            $conversacion->created_at = now();
            $conversacion->ultima_actividad = now();
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

    public function mensajes(): HasMany
    {
        return $this->hasMany(Mensaje::class)->orderBy('created_at', 'asc');
    }

    public function actualizarActividad(): void
    {
        $this->update(['ultima_actividad' => now()]);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('ultima_actividad', 'desc');
    }
}

// REFACTOR SUGGESTIONS:
// 1. Implementar método para contar mensajes no leídos
// 2. Agregar scope para conversaciones activas (últimas 24h)
// 3. Considerar soft deletes para archivar conversaciones
