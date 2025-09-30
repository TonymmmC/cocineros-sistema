<?php

namespace Tests\Feature\Policies;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $admin;
    private User $cocinero;
    private User $cliente;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->create(['role' => 'superadmin']);
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->cocinero = User::factory()->create(['role' => 'cocinero']);
        $this->cliente = User::factory()->create(['role' => 'cliente']);
    }

    public function test_superadmin_can_view_any_users(): void
    {
        $this->assertTrue($this->superAdmin->can('viewAny', User::class));
    }

    public function test_admin_can_view_any_users(): void
    {
        $this->assertTrue($this->admin->can('viewAny', User::class));
    }

    public function test_cocinero_cannot_view_any_users(): void
    {
        $this->assertFalse($this->cocinero->can('viewAny', User::class));
    }

    public function test_cliente_cannot_view_any_users(): void
    {
        $this->assertFalse($this->cliente->can('viewAny', User::class));
    }

    public function test_superadmin_can_create_users(): void
    {
        $this->assertTrue($this->superAdmin->can('create', User::class));
    }

    public function test_admin_can_create_users(): void
    {
        $this->assertTrue($this->admin->can('create', User::class));
    }

    public function test_cocinero_cannot_create_users(): void
    {
        $this->assertFalse($this->cocinero->can('create', User::class));
    }

    public function test_superadmin_can_update_any_user(): void
    {
        $otherUser = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($this->superAdmin->can('update', $otherUser));
    }

    public function test_admin_cannot_update_superadmin(): void
    {
        $this->assertFalse($this->admin->can('update', $this->superAdmin));
    }

    public function test_admin_can_update_regular_users(): void
    {
        $otherUser = User::factory()->create(['role' => 'cliente']);
        $this->assertTrue($this->admin->can('update', $otherUser));
    }

    public function test_user_can_update_own_profile(): void
    {
        $this->assertTrue($this->cliente->can('update', $this->cliente));
    }

    public function test_superadmin_can_delete_users_except_self(): void
    {
        $otherUser = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($this->superAdmin->can('delete', $otherUser));
        $this->assertFalse($this->superAdmin->can('delete', $this->superAdmin));
    }

    public function test_admin_cannot_delete_superadmin(): void
    {
        $this->assertFalse($this->admin->can('delete', $this->superAdmin));
    }

    public function test_cocinero_cannot_delete_users(): void
    {
        $otherUser = User::factory()->create(['role' => 'cliente']);
        $this->assertFalse($this->cocinero->can('delete', $otherUser));
    }

    public function test_gates_work_correctly(): void
    {
        $this->assertTrue($this->superAdmin->can('access-admin-panel'));
        $this->assertTrue($this->admin->can('access-admin-panel'));
        $this->assertFalse($this->cocinero->can('access-admin-panel'));
        $this->assertFalse($this->cliente->can('access-admin-panel'));

        $this->assertTrue($this->cocinero->can('manage-productos'));
        $this->assertFalse($this->cliente->can('manage-productos'));

        $this->assertTrue($this->cliente->can('create-pedido'));
        $this->assertFalse($this->cocinero->can('create-pedido'));
    }
}
