<?php

namespace App\Policies;

use App\Models\User;

class CocineroPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    public function view(User $user): bool
    {
        return $user->hasAdminAccess() || $user->isCocinero();
    }

    public function create(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    public function update(User $user): bool
    {
        return $user->hasAdminAccess() || $user->isCocinero();
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

// REFACTOR SUGGESTIONS:
// 1. Agregar método canManageOwnProfile() para separar lógica de edición propia vs admin
// 2. Implementar canViewProducts() para control granular de qué cocinero ve qué productos
// 3. Considerar trait SharedPolicyMethods si UserPolicy, ClientePolicy y CocineroPolicy comparten lógica
