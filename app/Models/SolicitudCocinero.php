<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudCocinero extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_cocinero';

    protected $fillable = [
        'user_id',
        'ci',
        'documento_ci_path',
        'nombre_completo',
        'direccion',
        'latitud',
        'longitud',
        'radio_entrega_km',
        'especialidades',
        'certificaciones',
        'bio',
        'estado',
        'razon_rechazo',
        'revisado_en',
        'revisado_por',
    ];

    protected $casts = [
        'especialidades' => 'array',
        'certificaciones' => 'array',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
        'radio_entrega_km' => 'decimal:2',
        'revisado_en' => 'datetime',
    ];

    /**
     * Relación: Una solicitud pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Solicitud revisada por un admin
     */
    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    /**
     * Scope: Solicitudes pendientes
     */
    public function scopePendiente($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope: Solicitudes aprobadas
     */
    public function scopeAprobado($query)
    {
        return $query->where('estado', 'aprobado');
    }

    /**
     * Scope: Solicitudes rechazadas
     */
    public function scopeRechazado($query)
    {
        return $query->where('estado', 'rechazado');
    }

    /**
     * Verificar si está pendiente
     */
    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    /**
     * Verificar si está aprobada
     */
    public function isAprobado(): bool
    {
        return $this->estado === 'aprobado';
    }

    /**
     * Verificar si está rechazada
     */
    public function isRechazado(): bool
    {
        return $this->estado === 'rechazado';
    }
}
