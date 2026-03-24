<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variante extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'talla',
        'color',
        'stock',
        'stock_reservado',
        'sku'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function detallesPedido()
    {
        return $this->hasMany(DetallePedido::class);
    }
}