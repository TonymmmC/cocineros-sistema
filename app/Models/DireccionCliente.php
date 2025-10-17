<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DireccionCliente extends Model
{
    use HasFactory;

    protected $table = 'direcciones_cliente';

    protected $fillable = [
        'cliente_id',
        'alias',
        'direccion_completa',
        'referencia',
        'latitud',
        'longitud',
        'es_principal',
    ];

    protected $casts = [
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
        'es_principal' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (DireccionCliente $direccion) {
            if ($direccion->es_principal) {
                self::where('cliente_id', $direccion->cliente_id)
                    ->update(['es_principal' => false]);
            }
        });

        static::updating(function (DireccionCliente $direccion) {
            if ($direccion->es_principal && $direccion->isDirty('es_principal')) {
                self::where('cliente_id', $direccion->cliente_id)
                    ->where('id', '!=', $direccion->id)
                    ->update(['es_principal' => false]);
            }
        });
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar validación de coordenadas (rango válido)
// 2. Implementar método para calcular distancia a un cocinero
// 3. Agregar scope para direcciones dentro de cierto radio
