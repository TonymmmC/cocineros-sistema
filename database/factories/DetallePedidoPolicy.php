<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetallePedidoFactory extends Factory
{
    public function definition(): array
    {
        $producto = Producto::factory()->create();
        $cantidad = fake()->numberBetween(1, 5);
        $precioUnitario = $producto->precio;
        $subtotal = $cantidad * $precioUnitario;

        return [
            'pedido_id' => Pedido::factory(),
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'subtotal' => $subtotal,
            'notas' => fake()->optional(0.3)->sentence(),
        ];
    }
}

// REFACTOR SUGGESTIONS:
// 1. Usar productos existentes en lugar de crear nuevos
// 2. Validar que cantidad no exceda stock_disponible
// 3. Implementar snapshot de producto por si se elimina después
