<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@cocineros.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'phone' => '+591 70123456',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Administrador',
                'email' => 'administrador@cocineros.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+591 70123457',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'María González',
                'email' => 'maria@cocineros.com',
                'password' => Hash::make('password'),
                'role' => 'cocinero',
                'phone' => '+591 70123458',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Carlos Mendoza',
                'email' => 'carlos@cocineros.com',
                'password' => Hash::make('password'),
                'role' => 'cocinero',
                'phone' => '+591 70123459',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Ana Rodríguez',
                'email' => 'ana@cocineros.com',
                'password' => Hash::make('password'),
                'role' => 'cocinero',
                'phone' => '+591 70123460',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Juan Pérez',
                'email' => 'juan@cliente.com',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'phone' => '+591 70123461',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Laura Silva',
                'email' => 'laura@cliente.com',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'phone' => '+591 70123462',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Pedro Morales',
                'email' => 'pedro@cliente.com',
                'password' => Hash::make('password'),
                'role' => 'cliente',
                'phone' => '+591 70123463',
                'is_verified' => true,
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
