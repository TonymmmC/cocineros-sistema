<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaccion extends Model
{
    use HasFactory;

    protected $table = 'transacciones';

    protected $fillable = [
        'pedido_id',
        'tipo',
        'monto',
        'metodo',
        'estado',
        'referencia_externa',
        'detalles',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'detalles' => 'array',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopeFallidas($query)
    {
        return $query->where('estado', 'fallida');
    }

    public function marcarComoCompletada(): void
    {
        $this->update(['estado' => 'completada']);
    }

    public function marcarComoFallida(string $razon = null): void
    {
        $detalles = $this->detalles ?? [];
        if ($razon) {
            $detalles['razon_fallo'] = $razon;
        }

        $this->update([
            'estado' => 'fallida',
            'detalles' => $detalles,
        ]);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Implementar eventos para sincronizar con estado_pago del pedido
// 2. Agregar método para reembolsar con validaciones
// 3. Implementar integración con pasarelas de pago reales
