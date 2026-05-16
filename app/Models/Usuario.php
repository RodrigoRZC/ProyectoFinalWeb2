<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'clave',
        'rol',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    // Le decimos a Laravel qué campo es el password
    public function getAuthPassword()
    {
        return $this->clave;
    }

    // Helpers de rol
    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    public function esGerente(): bool
    {
        return $this->rol === 'gerente';
    }

    public function esCliente(): bool
    {
        return $this->rol === 'cliente';
    }



    public function getAuthIdentifierName()
    {
        return 'correo';
    }



    // Usuario tiene muchos productos (como vendedor)
    public function productos()
    {
        return $this->hasMany(Producto::class, 'usuario_id');
    }

    // Usuario tiene muchas ventas como cliente
    public function ventasComoCliente()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    // Usuario tiene muchas ventas como vendedor
    public function ventasComoVendedor()
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    // hasManyThrough: Usuario → Productos → Categorías
    public function categorias()
    {
        return $this->hasManyThrough(
            Categoria::class,
            Producto::class,
            'usuario_id',    // FK en productos
            'id',            // FK en categorias
            'id',            // PK en usuarios
            'id'             // PK en productos
        )->join('categoria_producto', 'categorias.id', '=', 'categoria_producto.categoria_id')
         ->join('productos as p2', 'p2.id', '=', 'categoria_producto.producto_id')
         ->where('p2.usuario_id', '=', $this->id ?? 0)
         ->select('categorias.*')
         ->distinct();
    }



    // Total de vendedores (usuarios con rol gerente)
    public static function totalVendedores()
    {
        return static::where('rol', 'gerente')->count();
    }

    // Total de compradores (usuarios con rol cliente)
    public static function totalCompradores()
    {
        return static::where('rol', 'cliente')->count();
    }




}
