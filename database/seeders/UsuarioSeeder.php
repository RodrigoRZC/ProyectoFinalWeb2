<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador fijo
        Usuario::create([
            'nombre'    => 'Admin',
            'apellidos' => 'Sistema',
            'correo'    => 'admin@test.com',
            'clave'     => Hash::make('123'),
            'rol'       => 'administrador',
        ]);

        // 30 gerentes (vendedores)
        Usuario::factory(30)->gerente()->create();

        // 70 clientes (compradores)
        Usuario::factory(70)->cliente()->create();
    }
}
