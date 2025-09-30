<?php

namespace App\Policies;

use App\Models\User;

class ClientePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    public function view(User $user): bool
    {
        return $user->hasAdminAccess() || $user->isCliente();
    }

    public function create(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    public function update(User $user): bool
    {
        return $user->hasAdminAccess() || $user->isCliente();
    }

    public function delete(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    public function restore(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    public function forceDelete(User $user): bool
    {
        return $user->isSuperAdmin();
    }
}
