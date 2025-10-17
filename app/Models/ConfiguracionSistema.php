<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ConfiguracionSistema extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'configuracion_sistema';

    protected $fillable = [
        'clave',
        'valor',
        'tipo',
        'descripcion',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (ConfiguracionSistema $config) {
            $config->updated_at = now();
        });

        static::saved(function (ConfiguracionSistema $config) {
            Cache::forget('config_' . $config->clave);
        });

        static::deleted(function (ConfiguracionSistema $config) {
            Cache::forget('config_' . $config->clave);
        });
    }

    public static function obtener(string $clave, mixed $default = null): mixed
    {
        return Cache::remember('config_' . $clave, 3600, function () use ($clave, $default) {
            $config = self::where('clave', $clave)->first();

            if (!$config) {
                return $default;
            }

            return match ($config->tipo) {
                'numero' => (float) $config->valor,
                'booleano' => filter_var($config->valor, FILTER_VALIDATE_BOOLEAN),
                'json' => json_decode($config->valor, true),
                default => $config->valor,
            };
        });
    }

    public static function establecer(string $clave, mixed $valor, string $tipo = 'texto'): void
    {
        $valorGuardado = match ($tipo) {
            'numero' => (string) $valor,
            'booleano' => $valor ? '1' : '0',
            'json' => json_encode($valor),
            default => (string) $valor,
        };

        self::updateOrCreate(
            ['clave' => $clave],
            [
                'valor' => $valorGuardado,
                'tipo' => $tipo,
            ]
        );
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar validación de tipos antes de guardar
// 2. Implementar versioning para auditar cambios de configuración
// 3. Considerar usar Redis para cache en producción
