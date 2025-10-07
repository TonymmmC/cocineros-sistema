<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios con rol 'cocinero' o crear uno si no existe
        $cocineros = User::where('role', 'cocinero')->get();

        if ($cocineros->isEmpty()) {
            // Crear un usuario cocinero de prueba
            $cocinero = User::create([
                'name' => 'Doña María Condori',
                'email' => 'maria@cocinero.com',
                'password' => bcrypt('password'),
                'role' => 'cocinero',
                'phone' => '70123456',
                'is_verified' => true,
                'is_active' => true,
            ]);

            $cocineros = collect([$cocinero]);
        }

        // Crear 50 productos distribuidos entre los cocineros
        Producto::factory()
            ->count(50)
            ->create()
            ->each(function ($producto) use ($cocineros) {
                // Asignar un cocinero aleatorio a cada producto
                $producto->update([
                    'cocinero_id' => $cocineros->random()->id,
                ]);
            });
    }
}
