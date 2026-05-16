<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Categoria tiene muchos productos
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto');
    }
}
