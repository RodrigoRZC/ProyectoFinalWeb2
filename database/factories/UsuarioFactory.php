<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        $nombres   = ['Juan', 'Mario', 'Maria', 'Pedro'];
        $apellidos = ['Lopez', 'Sanchez', 'Hernandez', 'Martinez'];

        $nombre   = $this->faker->randomElement($nombres);
        $apellido = $this->faker->randomElement($apellidos);

        // Correo único con número aleatorio para evitar duplicados
        $correo = strtolower(substr($nombre, 0, 1) . $apellido)
            . $this->faker->unique()->numberBetween(1, 9999)
            . '@tuxtla.tecnm.mx';

        return [
            'nombre'    => $nombre,
            'apellidos' => $apellido,
            'correo'    => $correo,
            'clave'     => Hash::make('123'),
            'rol'       => 'cliente',
        ];
    }

    // Estado para gerente
    public function gerente(): static
    {
        return $this->state(fn() => ['rol' => 'gerente']);
    }

    // Estado para cliente
    public function cliente(): static
    {
        return $this->state(fn() => ['rol' => 'cliente']);
    }
}
