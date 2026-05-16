<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    // Ver listado — solo administrador
    public function viewAny(Usuario $usuario): bool
    {
        return $usuario->esAdministrador() || $usuario->esGerente();
    }

    // Crear — solo administrador
    public function create(Usuario $usuario): bool
    {
        return $usuario->esAdministrador();
    }

    // Editar — administrador puede editar a todos
    //          gerente solo puede editar clientes
    public function update(Usuario $usuario, Usuario $objetivo): bool
    {
        if ($usuario->esAdministrador()) {
            return true;
        }

        if ($usuario->esGerente()) {
            // Gerente solo puede editar clientes
            return $objetivo->esCliente();
        }

        return false;
    }

    // Eliminar — solo administrador
    public function delete(Usuario $usuario, Usuario $objetivo): bool
    {
        // No puede eliminarse a sí mismo
        if ($usuario->id === $objetivo->id) {
            return false;
        }

        return $usuario->esAdministrador();
    }
}
