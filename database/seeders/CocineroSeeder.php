<?php

namespace Database\Seeders;

use App\Models\Cocinero;
use App\Models\User;
use Illuminate\Database\Seeder;

class CocineroSeeder extends Seeder
{
    public function run(): void
    {
        $cocineros = [
            [
                'user_id' => User::where('email', 'maria@cocineros.com')->first()->id,
                'nombre_completo' => 'María González',
                'ci' => '12345678',
                'bio' => 'Especialista en comida tradicional boliviana con más de 10 años de experiencia.',
                'especialidades' => ['Comida Tradicional Boliviana', 'Sopas y Caldos', 'Carnes'],
                'certificaciones' => ['Manipulación de Alimentos', 'HACCP'],
                'direccion' => 'Zona Sur, Calle 1 #123, La Paz',
                'latitud' => -16.5000,
                'longitud' => -68.1500,
                'radio_entrega_km' => 5.00,
                'esta_disponible' => true,
                'calificacion_promedio' => 4.8,
                'total_pedidos' => 150,
            ],
            [
                'user_id' => User::where('email', 'carlos@cocineros.com')->first()->id,
                'nombre_completo' => 'Carlos Mendoza',
                'ci' => '87654321',
                'bio' => 'Chef especializado en comida internacional y fusion.',
                'especialidades' => ['Comida Italiana', 'Comida Asiática', 'Fusion'],
                'certificaciones' => ['Chef Profesional', 'Cocina Internacional'],
                'direccion' => 'Zona Norte, Av. 16 de Julio #456, La Paz',
                'latitud' => -16.4800,
                'longitud' => -68.1200,
                'radio_entrega_km' => 7.00,
                'esta_disponible' => true,
                'calificacion_promedio' => 4.6,
                'total_pedidos' => 89,
            ],
            [
                'user_id' => User::where('email', 'ana@cocineros.com')->first()->id,
                'nombre_completo' => 'Ana Rodríguez',
                'ci' => '11223344',
                'bio' => 'Especialista en comida saludable y vegana.',
                'especialidades' => ['Comida Vegana', 'Comida Saludable', 'Smoothies'],
                'certificaciones' => ['Nutrición', 'Cocina Vegana'],
                'direccion' => 'Zona Este, Calle 2 #789, La Paz',
                'latitud' => -16.5200,
                'longitud' => -68.1000,
                'radio_entrega_km' => 4.00,
                'esta_disponible' => true,
                'calificacion_promedio' => 4.9,
                'total_pedidos' => 67,
            ],
        ];

        foreach ($cocineros as $cocinero) {
            Cocinero::create($cocinero);
        }
    }
}
