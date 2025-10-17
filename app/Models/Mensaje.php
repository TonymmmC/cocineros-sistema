<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensaje extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'mensajes';

    protected $fillable = [
        'conversacion_id',
        'remitente_id',
        'mensaje',
        'tipo',
        'leido',
    ];

    protected $casts = [
        'leido' => 'boolean',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Mensaje $mensaje) {
            $mensaje->created_at = now();
        });

        static::created(function (Mensaje $mensaje) {
            $mensaje->conversacion->actualizarActividad();
        });
    }

    public function conversacion(): BelongsTo
    {
        return $this->belongsTo(Conversacion::class);
    }

    public function remitente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    public function marcarComoLeido(): void
    {
        $this->update(['leido' => true]);
    }

    public function scopeNoLeidos($query)
    {
        return $query->where('leido', false);
    }

    public function scopeTexto($query)
    {
        return $query->where('tipo', 'texto');
    }

    public function scopeImagen($query)
    {
        return $query->where('tipo', 'imagen');
    }

    public function scopeSistema($query)
    {
        return $query->where('tipo', 'sistema');
    }
}

// REFACTOR SUGGESTIONS:
// 1. Implementar WebSockets para mensajes en tiempo real
// 2. Agregar validación de longitud máxima de mensaje
// 3. Implementar encriptación para mensajes sensibles
