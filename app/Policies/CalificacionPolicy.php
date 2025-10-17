<?php

namespace App\Policies;

use App\Models\Calificacion;
use App\Models\User;

class CalificacionPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver calificaciones visibles
    }

    public function view(User $user, Calificacion $calificacion): bool
    {
        if ($calificacion->es_visible) {
            return true;
        }

        return $user->hasAdminAccess()
            || $calificacion->cliente->user_id === $user->id
            || $calificacion->cocinero->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isCliente();
    }

    public function update(User $user, Calificacion $calificacion): bool
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        return $calificacion->cliente->user_id === $user->id
            && $calificacion->created_at->diffInDays(now()) < 7;
    }

    public function delete(User $user, Calificacion $calificacion): bool
    {
        return $user->hasAdminAccess();
    }

    public function respond(User $user, Calificacion $calificacion): bool
    {
        return $calificacion->cocinero->user_id === $user->id
            && empty($calificacion->respuesta_cocinero);
    }

    public function moderate(User $user, Calificacion $calificacion): bool
    {
        return $user->hasAdminAccess();
    }
}

// REFACTOR SUGGESTIONS:
// 1. Agregar validación: solo calificar pedidos entregados
// 2. Implementar límite de tiempo para responder (ej: 30 días)
// 3. Agregar policy para marcar calificación como inapropiada
