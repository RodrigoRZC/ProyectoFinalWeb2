<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Categoria::all();
        $vendedores = Usuario::where('rol', 'gerente')->get();

        $nombresProductos = [
            'Laptop HP', 'Laptop Dell', 'Laptop Lenovo', 'Laptop Asus',
            'iPhone 15', 'Samsung Galaxy S24', 'Xiaomi Redmi', 'Motorola Edge',
            'Playera deportiva', 'Pantalón de mezclilla', 'Chamarra de cuero', 'Vestido casual',
            'Lámpara LED', 'Silla ergonómica', 'Mesa de escritorio', 'Sofá 3 plazas',
            'Balón de fútbol', 'Raqueta de tenis', 'Bicicleta de montaña', 'Guantes de box',
            'El principito', 'Cien años de soledad', 'Harry Potter', 'El Quijote',
            'Auriculares Sony', 'Teclado mecánico', 'Mouse inalámbrico', 'Monitor 4K',
            'Cafetera eléctrica', 'Licuadora Oster', 'Microondas Samsung', 'Refrigerador LG',
            'Mochila escolar', 'Maleta de viaje', 'Cartera de cuero', 'Cinturón casual',
            'Perfume Chanel', 'Crema facial', 'Shampoo Pantene', 'Maquillaje Mac',
            'Guitar Hero', 'Control Xbox', 'Memoria USB 64GB', 'Disco duro externo',
            'Cámara Canon', 'Trípode profesional', 'Lente 50mm', 'Flash externo',
            'Patines en línea', 'Tabla de surf', 'Casco de ciclismo', 'Rodilleras',
            'Arroz 5kg', 'Aceite de oliva', 'Café molido', 'Té verde',
            'Vitamina C', 'Omega 3', 'Proteína whey', 'Multivitamínico',
            'Cuaderno universitario', 'Plumas BIC x10', 'Calculadora Casio', 'Regla metálica',
            'Peluche osito', 'LEGO Creator', 'Barbie Fashionista', 'Hot Wheels x5',
            'Cable HDMI', 'Cargador inalámbrico', 'Funda iPhone', 'Protector de pantalla',
            'Jabón artesanal', 'Vela aromática', 'Difusor de aceites', 'Toalla de playa',
            'Martillo Stanley', 'Destornillador set', 'Cinta métrica', 'Nivel de burbuja',
            'Pintura acrílica', 'Lienzo 40x50', 'Pinceles set', 'Plastilina colores',
            'Semillas de jitomate', 'Maceta de barro', 'Tierra para plantas', 'Fertilizante',
            'Collar para perro', 'Comedero automático', 'Juguete para gato', 'Arena sanitaria',
            'Novela romántica', 'Libro de cocina', 'Atlas mundial', 'Diccionario español',
        ];

        $contador = 0;

        foreach ($vendedores as $vendedor) {
            // Mínimo 3 productos por vendedor
            $numProductos = rand(3, 5);

            for ($i = 0; $i < $numProductos; $i++) {
                $nombre = $nombresProductos[$contador % count($nombresProductos)]
                    . ' #' . ($contador + 1);

                $producto = Producto::create([
                    'nombre'      => $nombre,
                    'descripcion' => 'Descripción del producto ' . $nombre,
                    'precio'      => rand(50, 5000) + (rand(0, 99) / 100),
                    'existencia'  => rand(5, 100),
                    'usuario_id'  => $vendedor->id,
                    'fotos'       => [],
                ]);

                // Al menos 1 categoría por producto
                $numCats = rand(1, 3);
                $cats = $categorias->random($numCats)->pluck('id')->toArray();
                $producto->categorias()->sync($cats);

                $contador++;
            }
        }
    }
}
