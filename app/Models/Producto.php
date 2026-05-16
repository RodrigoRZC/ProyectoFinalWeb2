<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
    'nombre',
    'descripcion',
    'precio',
    'existencia',
    'usuario_id',
    'fotos',
    ];

    protected $casts = [
        'fotos' => 'array',
    ];

    // Producto pertenece a un usuario (vendedor)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Producto tiene muchas categorías
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    // Producto tiene muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'producto_id');
    }
}
