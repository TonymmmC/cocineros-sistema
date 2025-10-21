<?php

namespace Database\Seeders;

use App\Models\Conversacion;
use App\Models\Mensaje;
use App\Models\Cliente;
use App\Models\Cocinero;
use App\Models\Pedido;
use Illuminate\Database\Seeder;

class ConversacionSeeder extends Seeder
{
    public function run(): void
    {
        $pedidos = Pedido::all();

        foreach ($pedidos->take(2) as $pedido) {
            $conv = Conversacion::create([
                'pedido_id' => $pedido->id,
                'cliente_id' => $pedido->cliente_id,
                'cocinero_id' => $pedido->cocinero_id,
                'ultima_actividad' => now(),
            ]);

            // Crear mensajes para cada conversación
            Mensaje::create([
                'conversacion_id' => $conv->id,
                'remitente_id' => $pedido->cliente_id,
                'mensaje' => 'Hola, ¿tienes disponibilidad para hoy?',
                'tipo' => 'texto',
                'leido' => true,
            ]);

            Mensaje::create([
                'conversacion_id' => $conv->id,
                'remitente_id' => $pedido->cocinero_id,
                'mensaje' => 'Hola! Sí, tengo disponibilidad. ¿Qué te gustaría pedir?',
                'tipo' => 'texto',
                'leido' => false,
            ]);

            Mensaje::create([
                'conversacion_id' => $conv->id,
                'remitente_id' => $pedido->cliente_id,
                'mensaje' => 'Me interesa el silpancho tradicional',
                'tipo' => 'texto',
                'leido' => true,
            ]);
        }
    }
}
