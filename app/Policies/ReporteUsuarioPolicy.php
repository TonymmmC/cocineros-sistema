<?php

namespace App\Policies;

use App\Models\ReporteUsuario;
use App\Models\User;

class ReporteUsuarioPolicy
{
    /**
     * Determine if the user can view any reportes.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, ReporteUsuario $reporte): bool
    {
        return $user->hasAdminAccess() ||
               $user->id === $reporte->reportador_id;
    }

    /**
     * Determine if the user can create reportes.
     */
    public function create(User $user): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, ReporteUsuario $reporte): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, ReporteUsuario $reporte): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, ReporteUsuario $reporte): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, ReporteUsuario $reporte): bool
    {
        return $user->isSuperAdmin();
    }
}
