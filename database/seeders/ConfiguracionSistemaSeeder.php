<?php

namespace Database\Seeders;

use App\Models\ConfiguracionSistema;
use Illuminate\Database\Seeder;

class ConfiguracionSistemaSeeder extends Seeder
{
    public function run(): void
    {
        $configuraciones = [
            [
                'clave' => 'nombre_plataforma',
                'tipo' => 'texto',
                'valor' => 'Cocineros Bolivia',
                'descripcion' => 'Nombre de la plataforma',
            ],
            [
                'clave' => 'comision_porcentaje',
                'tipo' => 'numero',
                'valor' => '10',
                'descripcion' => 'Porcentaje de comisión por pedido',
            ],
            [
                'clave' => 'costo_entrega_base',
                'tipo' => 'numero',
                'valor' => '5.00',
                'descripcion' => 'Costo base de entrega en bolivianos',
            ],
            [
                'clave' => 'tiempo_maximo_preparacion',
                'tipo' => 'numero',
                'valor' => '60',
                'descripcion' => 'Tiempo máximo de preparación en minutos',
            ],
            [
                'clave' => 'habilitar_calificaciones',
                'tipo' => 'booleano',
                'valor' => 'true',
                'descripcion' => 'Habilitar sistema de calificaciones',
            ],
            [
                'clave' => 'radio_entrega_default',
                'tipo' => 'numero',
                'valor' => '5.00',
                'descripcion' => 'Radio de entrega por defecto en km',
            ],
            [
                'clave' => 'configuracion_notificaciones',
                'tipo' => 'json',
                'valor' => '{"email": true, "sms": false, "push": true}',
                'descripcion' => 'Configuración de notificaciones',
            ],
        ];

        foreach ($configuraciones as $config) {
            ConfiguracionSistema::create($config);
        }
    }
}
