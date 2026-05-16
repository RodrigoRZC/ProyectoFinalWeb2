<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoVerificacion extends Model
{
    protected $table = 'codigos_verificacion';

    protected $fillable = [
        'usuario_id',
        'codigo',
        'expiracion',
        'usado',
    ];

    protected $casts = [
        'expiracion' => 'datetime',
        'usado'      => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Verifica si el código ha expirado
    public function estaExpirado(): bool
    {
        return now()->greaterThan($this->expiracion);
    }
}
