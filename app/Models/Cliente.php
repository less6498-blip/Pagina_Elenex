<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'telefono',
    ];

    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function carrito()
    {
        return $this->hasOne(Carrito::class);
    }
}