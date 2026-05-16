<?php

namespace App\Policies;

use App\Models\Venta;
use App\Models\Usuario;

class VentaPolicy
{
    // Ver listado
    public function viewAny(Usuario $usuario): bool
    {
        // Cliente solo ve sus propias ventas, gerente y admin ven todas
        return true;
    }

    // Ver una
    public function view(Usuario $usuario, Venta $venta): bool
    {
        if ($usuario->esAdministrador() || $usuario->esGerente()) return true;
        return $venta->cliente_id === $usuario->id;
    }

    // Crear — todos los roles pueden comprar
    public function create(Usuario $usuario): bool
    {
        return in_array($usuario->rol, ['cliente', 'gerente', 'administrador']);
    }

    // Editar — solo administrador
    public function update(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador();
    }

    // Eliminar — solo administrador
    public function delete(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador();
    }
}
