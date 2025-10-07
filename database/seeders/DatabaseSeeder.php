<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@cocineros.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
            'is_verified' => true,
            'is_active' => true,
        ]);

        // Ejecutar seeders en orden
        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);
    }
}
