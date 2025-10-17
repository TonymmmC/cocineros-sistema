<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAdminAccess() || $user->isCocinero() || $user->isCliente();
    }

    public function view(User $user, Pedido $pedido): bool
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        if ($user->isCocinero()) {
            return $pedido->cocinero->user_id === $user->id;
        }

        if ($user->isCliente()) {
            return $pedido->cliente->user_id === $user->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isCliente();
    }

    public function update(User $user, Pedido $pedido): bool
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        if ($user->isCocinero() && $pedido->cocinero->user_id === $user->id) {
            return in_array($pedido->estado, ['pendiente', 'confirmado', 'preparando', 'listo']);
        }

        return false;
    }

    public function delete(User $user, Pedido $pedido): bool
    {
        return $user->isSuperAdmin();
    }

    public function cancel(User $user, Pedido $pedido): bool
    {
        if ($pedido->estado === 'entregado') {
            return false;
        }

        if ($user->isCliente() && $pedido->cliente->user_id === $user->id) {
            return $pedido->estado === 'pendiente';
        }

        if ($user->isCocinero() && $pedido->cocinero->user_id === $user->id) {
            return in_array($pedido->estado, ['pendiente', 'confirmado']);
        }

        return $user->hasAdminAccess();
    }
}

// REFACTOR SUGGESTIONS:
// 1. Extraer validaciones de estado a enum con reglas
// 2. Agregar policy para cambios de estado específicos
// 3. Implementar notificaciones cuando se deniegue acción
