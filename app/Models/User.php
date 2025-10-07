<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_verified',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCocinero(): bool
    {
        return $this->role === 'cocinero';
    }

    public function isCliente(): bool
    {
        return $this->role === 'cliente';
    }

    public function hasAdminAccess(): bool
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    /**
     * Relación: Un usuario puede ser cocinero
     */
    public function cocinero()
    {
        return $this->hasOne(Cocinero::class);
    }
}
