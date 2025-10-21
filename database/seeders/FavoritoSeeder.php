<?php

namespace Database\Seeders;

use App\Models\Favorito;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class FavoritoSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();
        $productos = Producto::all();

        $favoritos = [
            [
                'cliente_id' => $clientes->first()->id,
                'producto_id' => $productos->first()->id,
            ],
            [
                'cliente_id' => $clientes->first()->id,
                'producto_id' => $productos->skip(1)->first()->id,
            ],
            [
                'cliente_id' => $clientes->skip(1)->first()->id,
                'producto_id' => $productos->skip(2)->first()->id,
            ],
            [
                'cliente_id' => $clientes->skip(2)->first()->id,
                'producto_id' => $productos->skip(3)->first()->id,
            ],
        ];

        foreach ($favoritos as $favorito) {
            Favorito::create($favorito);
        }
    }
}
