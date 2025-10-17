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
                'clave' => 'comision_plataforma_porcentaje',
                'valor' => '15',
                'tipo' => 'numero',
                'descripcion' => 'Porcentaje de comisión que cobra la plataforma por pedido',
            ],
            [
                'clave' => 'radio_busqueda_km',
                'valor' => '10',
                'tipo' => 'numero',
                'descripcion' => 'Radio predeterminado de búsqueda de cocineros en kilómetros',
            ],
            [
                'clave' => 'tiempo_cancelacion_min',
                'valor' => '5',
                'tipo' => 'numero',
                'descripcion' => 'Tiempo máximo en minutos para cancelar un pedido sin penalización',
            ],
            [
                'clave' => 'min_calificacion_visible',
                'valor' => '1',
                'tipo' => 'numero',
                'descripcion' => 'Calificación mínima para que sea visible públicamente',
            ],
            [
                'clave' => 'costo_entrega_base',
                'valor' => '5',
                'tipo' => 'numero',
                'descripcion' => 'Costo base de entrega en bolivianos',
            ],
            [
                'clave' => 'max_productos_por_pedido',
                'valor' => '20',
                'tipo' => 'numero',
                'descripcion' => 'Número máximo de productos diferentes por pedido',
            ],
            [
                'clave' => 'plataforma_activa',
                'valor' => '1',
                'tipo' => 'booleano',
                'descripcion' => 'Indica si la plataforma está operativa',
            ],
        ];

        foreach ($configuraciones as $config) {
            ConfiguracionSistema::create($config);
        }
    }
}
