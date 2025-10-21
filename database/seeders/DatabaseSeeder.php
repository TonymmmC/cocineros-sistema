<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategoriaSeeder::class,
            UserSeeder::class,
            CocineroSeeder::class,
            ClienteSeeder::class,
            DireccionClienteSeeder::class,
            ProductoSeeder::class,
            PedidoSeeder::class,
            CalificacionSeeder::class,
            ConversacionSeeder::class,
            FavoritoSeeder::class,
            ConfiguracionSistemaSeeder::class,
        ]);
    }
}
