<?php

namespace Tests\Feature\Api;

use App\Models\Categoria;
use App\Models\Cocinero;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed categorías
        Categoria::factory()->create(['nombre' => 'Comida Tradicional']);
    }

    public function test_can_get_categorias(): void
    {
        $response = $this->getJson('/api/v1/categorias');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'nombre', 'slug', 'icono']
                     ]
                 ]);
    }

    public function test_can_get_productos(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'cocinero']);
        Producto::factory()->create(['cocinero_id' => $user->id]);

        $response = $this->getJson('/api/v1/productos');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'nombre', 'precio', 'descripcion']
                     ]
                 ]);
    }

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'user' => ['id', 'name', 'email', 'role'],
                     'token'
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'cliente',
        ]);
    }

    public function test_user_can_login(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'user',
                     'token'
                 ]);
    }

    public function test_cocinero_can_create_producto(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'cocinero']);

        /** @var \App\Models\Categoria $categoria */
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/productos', [
                             'categoria_id' => $categoria->id,
                             'nombre' => 'Salteña de Pollo',
                             'descripcion' => 'Deliciosa salteña',
                             'precio' => 8.50,
                             'tiempo_preparacion_min' => 30,
                             'porciones' => 1,
                             'disponible' => true,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'data' => ['id', 'nombre', 'precio']
                 ]);

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Salteña de Pollo',
            'cocinero_id' => $user->id,
        ]);
    }

    public function test_cliente_cannot_create_producto(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'cliente']);

        /** @var \App\Models\Categoria $categoria */
        $categoria = Categoria::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
                         ->postJson('/api/v1/productos', [
                             'categoria_id' => $categoria->id,
                             'nombre' => 'Test',
                             'descripcion' => 'Test',
                             'precio' => 10,
                             'tiempo_preparacion_min' => 30,
                             'porciones' => 1,
                         ]);

        $response->assertStatus(403);
    }
}

// INSTRUCCIONES DE EJECUCIÓN:
// php artisan test --filter ApiTest
// o
// php artisan test tests/Feature/Api/ApiTest.php
