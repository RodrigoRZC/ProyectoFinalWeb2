<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\Usuario;

class CategoriaPolicy
{
    // Ver listado — todos los autenticados
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    // Ver una — todos los autenticados
    public function view(Usuario $usuario, Categoria $categoria): bool
    {
        return true;
    }

    // Crear — solo administrador
    public function create(Usuario $usuario): bool
    {
        return $usuario->esAdministrador();
    }

    // Editar — solo administrador
    public function update(Usuario $usuario, Categoria $categoria): bool
    {
        return $usuario->esAdministrador();
    }

    // Eliminar — solo administrador
    public function delete(Usuario $usuario, Categoria $categoria): bool
    {
        return $usuario->esAdministrador();
    }
}
