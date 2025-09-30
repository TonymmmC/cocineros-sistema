<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\ClientePolicy;
use App\Policies\CocineroPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
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
    }
}
