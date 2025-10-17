<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'notas',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (DetallePedido $detalle) {
            $detalle->created_at = now();
            $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
        });

        static::updating(function (DetallePedido $detalle) {
            if ($detalle->isDirty(['cantidad', 'precio_unitario'])) {
                $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
            }
        });
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Validar que cantidad > 0 y precio_unitario > 0
// 2. Agregar validación de stock disponible antes de crear
// 3. Implementar snapshot del producto (guardar nombre, descripción por si se elimina)
