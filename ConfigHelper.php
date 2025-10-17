<?php

use App\Models\ConfiguracionSistema;

if (!function_exists('config_sistema')) {
    function config_sistema(string $clave, mixed $default = null): mixed
    {
        return ConfiguracionSistema::obtener($clave, $default);
    }
}

if (!function_exists('set_config_sistema')) {
    function set_config_sistema(string $clave, mixed $valor, string $tipo = 'texto'): void
    {
        ConfiguracionSistema::establecer($clave, $valor, $tipo);
    }
}
