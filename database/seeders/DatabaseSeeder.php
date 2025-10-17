<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@cocineros.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Ejecutar seeders en orden de dependencias
        $this->call([
            ConfiguracionSistemaSeeder::class,
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);
    }
}
