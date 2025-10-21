<?php

namespace Database\Seeders;

use App\Models\DireccionCliente;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class DireccionClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = Cliente::all();

        $direcciones = [
            [
                'cliente_id' => $clientes->first()->id,
                'alias' => 'Casa',
                'direccion_completa' => 'Zona Sur, Calle 1 #123, La Paz',
                'referencia' => 'Cerca del mercado',
                'latitud' => -16.5000,
                'longitud' => -68.1500,
                'es_principal' => true,
            ],
            [
                'cliente_id' => $clientes->skip(1)->first()->id,
                'alias' => 'Oficina',
                'direccion_completa' => 'Zona Norte, Av. 16 de Julio #456, La Paz',
                'referencia' => 'Edificio azul',
                'latitud' => -16.4800,
                'longitud' => -68.1200,
                'es_principal' => true,
            ],
            [
                'cliente_id' => $clientes->skip(2)->first()->id,
                'alias' => 'Casa',
                'direccion_completa' => 'Zona Este, Calle 2 #789, La Paz',
                'referencia' => 'Casa con portón verde',
                'latitud' => -16.5200,
                'longitud' => -68.1000,
                'es_principal' => true,
            ],
        ];

        foreach ($direcciones as $direccion) {
            DireccionCliente::create($direccion);
        }
    }
}
