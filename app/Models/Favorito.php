<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorito extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'producto_id',
        'cocinero_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Favorito $favorito) {
            $favorito->created_at = now();
        });
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function cocinero(): BelongsTo
    {
        return $this->belongsTo(Cocinero::class);
    }

    public function scopeProductos($query)
    {
        return $query->whereNotNull('producto_id');
    }

    public function scopeCocineros($query)
    {
        return $query->whereNotNull('cocinero_id');
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar validación: debe tener producto O cocinero, no ambos ni ninguno
// 2. Implementar método para verificar si existe favorito antes de crear
// 3. Agregar scope para favoritos recientes (últimos N días)
