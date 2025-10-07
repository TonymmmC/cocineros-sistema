<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        $platosBolivianos = [
            ['Salteña de Pollo', 'Deliciosa salteña jugosa rellena de pollo, papas, arvejas y un toque picante', 8.00],
            ['Salteña de Carne', 'Tradicional salteña paceña con carne de res, huevo duro y especias', 8.50],
            ['Anticucho de Corazón', 'Brochetas de corazón de res marinado con especias y ají', 15.00],
            ['Sajta de Pollo', 'Pollo desmenuzado en salsa de ají amarillo con chuño y arroz', 25.00],
            ['Fricasé Paceño', 'Cerdo cocido en salsa de ají amarillo con mote y chuño', 28.00],
            ['Plato Paceño', 'Choclo, habas, papa, queso y salsa de ají. Un clásico!', 22.00],
            ['Chairo Paceño', 'Sopa espesa con carne, chuño, verduras y hierbas aromáticas', 18.00],
            ['Silpancho Cochabambino', 'Carne apanada con arroz, papa, huevo frito y ensalada', 30.00],
            ['Pique Macho', 'Carne, salchicha, papas fritas, huevo, locoto y salsa', 35.00],
            ['Chicharrón de Cerdo', 'Cerdo frito con mote, llajwa y ensalada fresca', 32.00],
            ['Empanada de Queso', 'Masa crocante rellena de queso derretido', 5.00],
            ['Api con Pastel', 'Bebida caliente de maíz morado con pastel de queso', 10.00],
            ['Sopa de Maní', 'Cremosa sopa de maní con fideos y carne', 20.00],
            ['Picante de Pollo', 'Pollo en salsa picante con papas y arroz', 26.00],
            ['Ají de Fideo', 'Fideos en salsa de ají amarillo con carne molida', 22.00],
        ];

        $plato = fake()->randomElement($platosBolivianos);

        $ingredientes = [
            ['Pollo', 'Papas', 'Cebolla', 'Ají amarillo', 'Especias'],
            ['Carne de res', 'Huevo', 'Arvejas', 'Cebolla', 'Comino'],
            ['Corazón', 'Ají panca', 'Vinagre', 'Ajo', 'Comino'],
            ['Chuño', 'Ají', 'Cebolla', 'Papa', 'Arroz'],
            ['Cerdo', 'Mote', 'Ají amarillo', 'Cebolla', 'Especias'],
        ];

        $alergenos = [];
        if (fake()->boolean(20)) {
            $alergenos = fake()->randomElements(['Gluten', 'Lácteos', 'Huevo', 'Maní'], fake()->numberBetween(1, 2));
        }

        $esVegetariano = fake()->boolean(25);
        $esVegano = $esVegetariano ? fake()->boolean(40) : false;

        return [
            'cocinero_id' => null, // Lo asignaremos en el seeder
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? 1,
            'nombre' => $plato[0],
            'descripcion' => $plato[1],
            'precio' => $plato[2],
            'tiempo_preparacion_min' => fake()->randomElement([15, 20, 25, 30, 35, 40, 45, 60]),
            'imagenes' => [], // Las imágenes se pueden agregar manualmente después
            'ingredientes' => fake()->randomElement($ingredientes),
            'alergenos' => $alergenos,
            'porciones' => fake()->randomElement([1, 2, 4]),
            'disponible' => fake()->boolean(85),
            'stock_disponible' => fake()->boolean(70) ? fake()->numberBetween(5, 50) : null,
            'es_vegetariano' => $esVegetariano,
            'es_vegano' => $esVegano,
            'es_sin_gluten' => fake()->boolean(15),
            'vistas' => fake()->numberBetween(0, 500),
        ];
    }
}
