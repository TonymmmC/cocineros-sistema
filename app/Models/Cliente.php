<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre_completo',
        'foto_perfil',
        'preferencias_alimentarias',
    ];

    protected $casts = [
        'preferencias_alimentarias' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function direcciones(): HasMany
    {
        return $this->hasMany(DireccionCliente::class);
    }

    public function direccionPrincipal()
    {
        return $this->hasOne(DireccionCliente::class)->where('es_principal', true);
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class);
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar scope para clientes activos (basado en user->is_active)
// 2. Implementar método para contar pedidos completados
// 3. Agregar método para verificar si tiene direcciones registradas
