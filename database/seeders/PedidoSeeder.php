<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Cocinero;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $cocineros = Cocinero::all();

        $pedidos = [
            [
                'codigo_pedido' => 'PED-001',
                'cliente_id' => $clientes->first()->id,
                'cocinero_id' => $cocineros->first()->id,
                'direccion_id' => 1, // Asumiendo que existe
                'estado' => 'entregado',
                'subtotal' => 45.00,
                'comision_plataforma' => 4.50,
                'costo_entrega' => 5.00,
                'total' => 54.50,
                'metodo_pago' => 'efectivo',
                'estado_pago' => 'pagado',
                'notas_cliente' => 'Sin cebolla por favor',
                'tiempo_estimado_min' => 25,
                'fecha_confirmacion' => now()->subHours(2),
                'fecha_listo' => now()->subHours(1),
                'fecha_entrega' => now()->subMinutes(30),
            ],
            [
                'codigo_pedido' => 'PED-002',
                'cliente_id' => $clientes->skip(1)->first()->id,
                'cocinero_id' => $cocineros->skip(1)->first()->id,
                'direccion_id' => 2,
                'estado' => 'en_camino',
                'subtotal' => 65.00,
                'comision_plataforma' => 6.50,
                'costo_entrega' => 7.00,
                'total' => 78.50,
                'metodo_pago' => 'tarjeta',
                'estado_pago' => 'pagado',
                'notas_cliente' => 'Entregar en la puerta principal',
                'tiempo_estimado_min' => 20,
                'fecha_confirmacion' => now()->subMinutes(30),
                'fecha_listo' => now()->subMinutes(10),
            ],
            [
                'codigo_pedido' => 'PED-003',
                'cliente_id' => $clientes->skip(2)->first()->id,
                'cocinero_id' => $cocineros->skip(2)->first()->id,
                'direccion_id' => 3,
                'estado' => 'preparando',
                'subtotal' => 40.00,
                'comision_plataforma' => 4.00,
                'costo_entrega' => 5.00,
                'total' => 49.00,
                'metodo_pago' => 'qr',
                'estado_pago' => 'pagado',
                'notas_cliente' => 'Extra picante',
                'tiempo_estimado_min' => 15,
                'fecha_confirmacion' => now()->subMinutes(15),
            ],
            [
                'codigo_pedido' => 'PED-004',
                'cliente_id' => $clientes->first()->id,
                'cocinero_id' => $cocineros->skip(2)->first()->id,
                'direccion_id' => 1,
                'estado' => 'pendiente',
                'subtotal' => 25.00,
                'comision_plataforma' => 2.50,
                'costo_entrega' => 5.00,
                'total' => 32.50,
                'metodo_pago' => 'efectivo',
                'estado_pago' => 'pendiente',
                'notas_cliente' => 'Para llevar',
                'tiempo_estimado_min' => 10,
            ],
        ];

        foreach ($pedidos as $pedido) {
            Pedido::create($pedido);
        }
    }
}
