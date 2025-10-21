<?php

namespace Database\Seeders;

use App\Models\Cocinero;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $cocineros = Cocinero::all();
        $categorias = Categoria::all();

        $productos = [
            [
                'cocinero_id' => $cocineros->first()->id,
                'categoria_id' => $categorias->where('nombre', 'Comida Tradicional')->first()->id,
                'nombre' => 'Silpancho Tradicional',
                'descripcion' => 'Delicioso silpancho con arroz, papa, huevo frito y ensalada fresca.',
                'precio' => 45.00,
                'tiempo_preparacion_min' => 25,
                'imagenes' => ['silpancho1.jpg', 'silpancho2.jpg'],
                'ingredientes' => ['Carne de res', 'Arroz', 'Papa', 'Huevo', 'Tomate', 'Cebolla'],
                'alergenos' => ['Huevo', 'Gluten'],
                'porciones' => 1,
                'disponible' => true,
                'stock_disponible' => 10,
                'es_vegetariano' => false,
                'es_vegano' => false,
                'es_sin_gluten' => false,
                'vistas' => 156,
            ],
            [
                'cocinero_id' => $cocineros->first()->id,
                'categoria_id' => $categorias->where('nombre', 'Comida Tradicional')->first()->id,
                'nombre' => 'Sopa de Maní',
                'descripcion' => 'Sopa tradicional boliviana con maní, verduras y carne.',
                'precio' => 35.00,
                'tiempo_preparacion_min' => 30,
                'imagenes' => ['sopa_mani1.jpg'],
                'ingredientes' => ['Maní', 'Papa', 'Zanahoria', 'Cebolla', 'Carne'],
                'alergenos' => ['Maní'],
                'porciones' => 1,
                'disponible' => true,
                'stock_disponible' => 15,
                'es_vegetariano' => false,
                'es_vegano' => false,
                'es_sin_gluten' => true,
                'vistas' => 89,
            ],
            [
                'cocinero_id' => $cocineros->skip(1)->first()->id,
                'categoria_id' => $categorias->where('nombre', 'Comida Internacional')->first()->id,
                'nombre' => 'Pizza Margherita',
                'descripcion' => 'Pizza italiana clásica con tomate, mozzarella y albahaca fresca.',
                'precio' => 65.00,
                'tiempo_preparacion_min' => 20,
                'imagenes' => ['pizza1.jpg', 'pizza2.jpg'],
                'ingredientes' => ['Masa', 'Tomate', 'Mozzarella', 'Albahaca', 'Aceite de oliva'],
                'alergenos' => ['Gluten', 'Lactosa'],
                'porciones' => 1,
                'disponible' => true,
                'stock_disponible' => 8,
                'es_vegetariano' => true,
                'es_vegano' => false,
                'es_sin_gluten' => false,
                'vistas' => 234,
            ],
            [
                'cocinero_id' => $cocineros->skip(2)->first()->id,
                'categoria_id' => $categorias->where('nombre', 'Comida Vegana')->first()->id,
                'nombre' => 'Bowl Vegano',
                'descripcion' => 'Bowl nutritivo con quinoa, verduras frescas y aderezo vegano.',
                'precio' => 40.00,
                'tiempo_preparacion_min' => 15,
                'imagenes' => ['bowl_vegano1.jpg'],
                'ingredientes' => ['Quinoa', 'Aguacate', 'Tomate', 'Lechuga', 'Garbanzos'],
                'alergenos' => [],
                'porciones' => 1,
                'disponible' => true,
                'stock_disponible' => 12,
                'es_vegetariano' => true,
                'es_vegano' => true,
                'es_sin_gluten' => true,
                'vistas' => 178,
            ],
            [
                'cocinero_id' => $cocineros->skip(2)->first()->id,
                'categoria_id' => $categorias->where('nombre', 'Postres')->first()->id,
                'nombre' => 'Torta de Chocolate Vegana',
                'descripcion' => 'Deliciosa torta de chocolate sin ingredientes de origen animal.',
                'precio' => 25.00,
                'tiempo_preparacion_min' => 10,
                'imagenes' => ['torta_chocolate1.jpg'],
                'ingredientes' => ['Harina de avena', 'Cacao', 'Leche de almendras', 'Azúcar de coco'],
                'alergenos' => ['Gluten'],
                'porciones' => 1,
                'disponible' => true,
                'stock_disponible' => 20,
                'es_vegetariano' => true,
                'es_vegano' => true,
                'es_sin_gluten' => false,
                'vistas' => 145,
            ],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
