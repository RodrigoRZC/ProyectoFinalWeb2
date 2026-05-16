<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\Usuario;

class ProductoPolicy
{
    // Ver listado — todos los autenticados
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    // Ver uno — todos los autenticados
    public function view(Usuario $usuario, Producto $producto): bool
    {
        return true;
    }

    // Crear — solo administrador y gerente
    public function create(Usuario $usuario): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    // Editar — administrador puede todo, gerente solo sus productos
    public function update(Usuario $usuario, Producto $producto): bool
    {
        if ($usuario->esAdministrador()) return true;
        if ($usuario->esGerente()) return $producto->usuario_id === $usuario->id;
        return false;
    }

    // Eliminar — solo administrador
    public function delete(Usuario $usuario, Producto $producto): bool
    {
        return $usuario->esAdministrador();
    }
}
