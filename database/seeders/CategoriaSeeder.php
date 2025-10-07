<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Comida Tradicional',
                'slug' => 'comida-tradicional',
                'icono' => 'cake',
                'orden' => 1,
                'is_active' => true,
            ],
            [
                'nombre' => 'Comida Internacional',
                'slug' => 'comida-internacional',
                'icono' => 'globe-alt',
                'orden' => 2,
                'is_active' => true,
            ],
            [
                'nombre' => 'Comida Vegana',
                'slug' => 'comida-vegana',
                'icono' => 'sparkles',
                'orden' => 3,
                'is_active' => true,
            ],
            [
                'nombre' => 'Comida Vegetariana',
                'slug' => 'comida-vegetariana',
                'icono' => 'leaf',
                'orden' => 4,
                'is_active' => true,
            ],
            [
                'nombre' => 'Postres',
                'slug' => 'postres',
                'icono' => 'gift',
                'orden' => 5,
                'is_active' => true,
            ],
            [
                'nombre' => 'Bebidas',
                'slug' => 'bebidas',
                'icono' => 'beaker',
                'orden' => 6,
                'is_active' => true,
            ],
            [
                'nombre' => 'Comida Rápida',
                'slug' => 'comida-rapida',
                'icono' => 'bolt',
                'orden' => 7,
                'is_active' => true,
            ],
            [
                'nombre' => 'Comida Saludable',
                'slug' => 'comida-saludable',
                'icono' => 'heart',
                'orden' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
