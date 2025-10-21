<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'user_id' => User::where('email', 'juan@cliente.com')->first()->id,
                'nombre_completo' => 'Juan Pérez',
                'preferencias_alimentarias' => ['Sin gluten', 'Bajo en sodio'],
            ],
            [
                'user_id' => User::where('email', 'laura@cliente.com')->first()->id,
                'nombre_completo' => 'Laura Silva',
                'preferencias_alimentarias' => ['Vegetariano', 'Orgánico'],
            ],
            [
                'user_id' => User::where('email', 'pedro@cliente.com')->first()->id,
                'nombre_completo' => 'Pedro Morales',
                'preferencias_alimentarias' => ['Sin lactosa', 'Picante'],
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }
    }
}
