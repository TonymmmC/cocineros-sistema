<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteUsuario extends Model
{
    use HasFactory;

    protected $table = 'reportes_usuario';

    protected $fillable = [
        'reportador_id',
        'reportado_id',
        'pedido_id',
        'motivo',
        'descripcion',
        'estado',
        'accion_tomada',
    ];

    public function reportador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reportador_id');
    }

    public function reportado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reportado_id');
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function marcarEnRevision(): void
    {
        $this->update(['estado' => 'en_revision']);
    }

    public function resolver(string $accion): void
    {
        $this->update([
            'estado' => 'resuelto',
            'accion_tomada' => $accion,
        ]);
    }

    public function rechazar(string $razon): void
    {
        $this->update([
            'estado' => 'rechazado',
            'accion_tomada' => $razon,
        ]);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnRevision($query)
    {
        return $query->where('estado', 'en_revision');
    }

    public function scopeResueltos($query)
    {
        return $query->where('estado', 'resuelto');
    }
}

// REFACTOR SUGGESTIONS:
// 1. Implementar sistema de prioridades para reportes críticos
// 2. Agregar notificaciones automáticas a admin cuando se crea reporte
// 3. Implementar prevención de spam (límite de reportes por usuario)
