<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Cocinero;
use App\Models\DireccionCliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    public function definition(): array
    {
        $estado = fake()->randomElement([
            'pendiente',
            'confirmado',
            'preparando',
            'listo',
            'en_camino',
            'entregado',
            'cancelado',
        ]);

        $subtotal = fake()->randomFloat(2, 20, 200);
        $comisionPorcentaje = 15 / 100;
        $comision = $subtotal * $comisionPorcentaje;
        $costoEntrega = 5.00;
        $total = $subtotal + $comision + $costoEntrega;

        return [
            'codigo_pedido' => null, // Se genera automáticamente
            'cliente_id' => Cliente::factory(),
            'cocinero_id' => Cocinero::factory(),
            'direccion_id' => DireccionCliente::factory(),
            'estado' => $estado,
            'subtotal' => $subtotal,
            'comision_plataforma' => $comision,
            'costo_entrega' => $costoEntrega,
            'total' => $total,
            'metodo_pago' => fake()->randomElement(['qr', 'tarjeta', 'efectivo']),
            'estado_pago' => $estado === 'entregado' ? 'pagado' : 'pendiente',
            'notas_cliente' => fake()->optional()->sentence(),
            'tiempo_estimado_min' => fake()->numberBetween(20, 60),
            'fecha_confirmacion' => in_array($estado, ['confirmado', 'preparando', 'listo', 'en_camino', 'entregado']) ? now()->subMinutes(30) : null,
            'fecha_listo' => in_array($estado, ['listo', 'en_camino', 'entregado']) ? now()->subMinutes(15) : null,
            'fecha_entrega' => $estado === 'entregado' ? now() : null,
            'fecha_cancelacion' => $estado === 'cancelado' ? now() : null,
            'motivo_cancelacion' => $estado === 'cancelado' ? fake()->sentence() : null,
        ];
    }

    public function pendiente(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'pendiente',
            'fecha_confirmacion' => null,
            'fecha_listo' => null,
            'fecha_entrega' => null,
        ]);
    }

    public function entregado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'entregado',
            'estado_pago' => 'pagado',
            'fecha_confirmacion' => now()->subHours(2),
            'fecha_listo' => now()->subHours(1),
            'fecha_entrega' => now(),
        ]);
    }

    public function cancelado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => 'cancelado',
            'fecha_cancelacion' => now(),
            'motivo_cancelacion' => fake()->sentence(),
        ]);
    }
}

// REFACTOR SUGGESTIONS:
// 1. Extraer cálculo de totales a trait reutilizable
// 2. Agregar state para pedidos con productos reales asociados
// 3. Implementar validación de estados posibles según reglas de negocio
