<?php

namespace Database\Seeders;

use App\Models\Calificacion;
use App\Models\Cliente;
use App\Models\Cocinero;
use App\Models\Pedido;
use Illuminate\Database\Seeder;

class CalificacionSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $cocineros = Cocinero::all();
        $pedidos = Pedido::all();

        $calificaciones = [
            [
                'cliente_id' => $clientes->first()->id,
                'cocinero_id' => $cocineros->first()->id,
                'pedido_id' => $pedidos->first()->id,
                'puntuacion' => 5,
                'comentario' => 'Excelente comida, muy rica y bien preparada. Recomendado!',
            ],
            [
                'cliente_id' => $clientes->skip(1)->first()->id,
                'cocinero_id' => $cocineros->skip(1)->first()->id,
                'pedido_id' => $pedidos->skip(1)->first()->id,
                'puntuacion' => 4,
                'comentario' => 'Muy buena pizza, llegó caliente y a tiempo.',
            ],
            [
                'cliente_id' => $clientes->skip(2)->first()->id,
                'cocinero_id' => $cocineros->skip(2)->first()->id,
                'pedido_id' => $pedidos->skip(2)->first()->id,
                'puntuacion' => 5,
                'comentario' => 'Perfecto para mi dieta vegana, muy nutritivo y sabroso.',
            ],
            [
                'cliente_id' => $clientes->first()->id,
                'cocinero_id' => $cocineros->skip(2)->first()->id,
                'pedido_id' => $pedidos->skip(3)->first()->id,
                'puntuacion' => 4,
                'comentario' => 'Buen postre vegano, aunque un poco caro.',
            ],
        ];

        foreach ($calificaciones as $calificacion) {
            Calificacion::create($calificacion);
        }
    }
}
