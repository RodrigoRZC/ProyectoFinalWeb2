<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
    'producto_id',
    'vendedor_id',
    'cliente_id',
    'fecha',
    'total',
    'ticket',
    'validada',
    ];

    protected $casts = [
        'validada' => 'boolean',
    ];

    // Venta pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Venta pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }

    // Venta pertenece a un vendedor
    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'vendedor_id');
    }


    // Producto más vendido
    public static function productoMasVendido()
    {
        return static::selectRaw('producto_id, count(*) as total_ventas')
            ->groupBy('producto_id')
            ->orderByDesc('total_ventas')
            ->with('producto')
            ->first();
    }

    // Comprador más frecuente
    public static function compradorMasFrecuente()
    {
        return static::selectRaw('cliente_id, count(*) as total_compras')
            ->groupBy('cliente_id')
            ->orderByDesc('total_compras')
            ->with('cliente')
            ->first();
    }



}
