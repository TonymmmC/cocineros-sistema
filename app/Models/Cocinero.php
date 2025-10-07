<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cocinero extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_completo',
        'ci',
        'foto_perfil',
        'bio',
        'especialidades',
        'certificaciones',
        'direccion',
        'latitud',
        'longitud',
        'radio_entrega_km',
        'esta_disponible',
        'calificacion_promedio',
        'total_pedidos',
    ];

    protected $casts = [
        'especialidades' => 'array',
        'certificaciones' => 'array',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
        'radio_entrega_km' => 'decimal:2',
        'esta_disponible' => 'boolean',
        'calificacion_promedio' => 'decimal:2',
        'total_pedidos' => 'integer',
    ];

    /**
     * Relación: Un cocinero pertenece a un usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Un cocinero tiene muchos productos
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    /**
     * Scope: solo cocineros disponibles
     */
    public function scopeDisponible($query)
    {
        return $query->where('esta_disponible', true);
    }

    /**
     * Scope: ordenar por calificación
     */
    public function scopeTopRated($query)
    {
        return $query->orderBy('calificacion_promedio', 'desc');
    }

    /**
     * Accessor: nombre completo del usuario asociado
     */
    public function getNombreUsuarioAttribute(): string
    {
        return $this->user->name ?? 'Sin usuario';
    }

    /**
     * Accessor: total de productos activos
     */
    public function getProductosActivosCountAttribute(): int
    {
        return $this->productos()->where('disponible', true)->count();
    }

    /**
     * Incrementar total de pedidos
     */
    public function incrementarPedidos(): void
    {
        $this->increment('total_pedidos');
    }

    /**
     * Actualizar calificación promedio
     */
    public function actualizarCalificacion(float $nuevaCalificacion): void
    {
        $totalCalificaciones = $this->total_pedidos;

        if ($totalCalificaciones > 0) {
            $sumaActual = $this->calificacion_promedio * $totalCalificaciones;
            $nuevoPromedio = ($sumaActual + $nuevaCalificacion) / ($totalCalificaciones + 1);

            $this->update([
                'calificacion_promedio' => round($nuevoPromedio, 2),
            ]);
        } else {
            $this->update([
                'calificacion_promedio' => $nuevaCalificacion,
            ]);
        }
    }
}
