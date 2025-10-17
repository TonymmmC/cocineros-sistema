<?php

namespace App\Providers;

use App\Models\Calificacion;
use App\Models\Cliente;
use App\Models\Cocinero;
use App\Models\Pedido;
use App\Models\User;
use App\Policies\CalificacionPolicy;
use App\Policies\ClientePolicy;
use App\Policies\CocineroPolicy;
use App\Policies\PedidoPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Cocinero::class => CocineroPolicy::class,
        Cliente::class => ClientePolicy::class,
        Pedido::class => PedidoPolicy::class,
        Calificacion::class => CalificacionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin-panel', function (User $user) {
            return $user->hasAdminAccess();
        });

        Gate::define('manage-cocineros', function (User $user) {
            return $user->hasAdminAccess();
        });

        Gate::define('manage-clientes', function (User $user) {
            return $user->hasAdminAccess();
        });

        Gate::define('manage-productos', function (User $user) {
            return $user->hasAdminAccess() || $user->isCocinero();
        });

        Gate::define('manage-pedidos', function (User $user) {
            return $user->hasAdminAccess() || $user->isCocinero();
        });

        Gate::define('create-pedido', function (User $user) {
            return $user->isCliente();
        });

        Gate::define('view-reportes', function (User $user) {
            return $user->hasAdminAccess();
        });

        Gate::define('manage-configuracion', function (User $user) {
            return $user->isSuperAdmin();
        });

        Gate::define('moderate-content', function (User $user) {
            return $user->hasAdminAccess();
        });

        Gate::define('view-analytics', function (User $user) {
            return $user->hasAdminAccess() || $user->isCocinero();
        });
    }
}

// REFACTOR SUGGESTIONS:
// 1. Considerar usar paquete de permisos como Spatie Laravel Permission
// 2. Agregar more granular permissions por módulo
// 3. Implementar roles dinámicos desde base de datos
