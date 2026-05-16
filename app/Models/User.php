<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Métodos helper para verificar el rol
    public function isCliente(): bool
    {
        return $this->role === 'cliente';
    }

    public function isEmpleado(): bool
    {
        return $this->role === 'empleado';
    }

    public function isGerente(): bool
    {
        return $this->role === 'gerente';
    }
}
