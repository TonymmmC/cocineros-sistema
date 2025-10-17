<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_pedido',
        'cliente_id',
        'cocinero_id',
        'direccion_id',
        'estado',
        'subtotal',
        'comision_plataforma',
        'costo_entrega',
        'total',
        'metodo_pago',
        'estado_pago',
        'notas_cliente',
        'tiempo_estimado_min',
        'fecha_confirmacion',
        'fecha_listo',
        'fecha_entrega',
        'fecha_cancelacion',
        'motivo_cancelacion',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'comision_plataforma' => 'decimal:2',
        'costo_entrega' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_confirmacion' => 'datetime',
        'fecha_listo' => 'datetime',
        'fecha_entrega' => 'datetime',
        'fecha_cancelacion' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Pedido $pedido) {
            if (empty($pedido->codigo_pedido)) {
                $pedido->codigo_pedido = 'PED-' . strtoupper(Str::random(10));
            }
        });

        static::created(function (Pedido $pedido) {
            $pedido->cocinero->incrementarPedidos();
        });
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cocinero(): BelongsTo
    {
        return $this->belongsTo(Cocinero::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(DireccionCliente::class, 'direccion_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class);
    }

    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }

    public function conversacion()
    {
        return $this->hasOne(Conversacion::class);
    }

    public function calcularTotales(): void
    {
        $this->subtotal = $this->detalles->sum('subtotal');

        $comisionPorcentaje = config_sistema('comision_plataforma_porcentaje', 15) / 100;
        $this->comision_plataforma = $this->subtotal * $comisionPorcentaje;

        $this->total = $this->subtotal + $this->comision_plataforma + $this->costo_entrega;

        $this->save();
    }

    public function cambiarEstado(string $nuevoEstado): void
    {
        $this->estado = $nuevoEstado;

        match ($nuevoEstado) {
            'confirmado' => $this->fecha_confirmacion = now(),
            'listo' => $this->fecha_listo = now(),
            'entregado' => $this->fecha_entrega = now(),
            'cancelado' => $this->fecha_cancelacion = now(),
            default => null,
        };

        $this->save();
    }

    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['pendiente', 'confirmado', 'preparando', 'listo', 'en_camino']);
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'entregado');
    }

    public function scopeCancelados($query)
    {
        return $query->where('estado', 'cancelado');
    }
}

// REFACTOR SUGGESTIONS:
// 1. Extraer cálculo de comisión a servicio/helper reutilizable
// 2. Implementar máquina de estados con validaciones (FSM)
// 3. Agregar eventos para notificar cambios de estado
