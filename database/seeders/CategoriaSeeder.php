<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre'      => 'Electrónica',
                'descripcion' => 'Dispositivos electrónicos y accesorios',
            ],
            [
                'nombre'      => 'Ropa',
                'descripcion' => 'Prendas de vestir para todas las edades',
            ],
            [
                'nombre'      => 'Hogar',
                'descripcion' => 'Artículos para el hogar y decoración',
            ],
            [
                'nombre'      => 'Deportes',
                'descripcion' => 'Equipos y ropa deportiva',
            ],
            [
                'nombre'      => 'Libros',
                'descripcion' => 'Libros de todos los géneros',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
