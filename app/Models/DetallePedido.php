<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'variante_id',
        'cantidad',
        'precio',
        'subtotal_linea'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function variante()
    {
        return $this->belongsTo(Variante::class);
    }

    public function devolucion()
    {
        return $this->hasOne(Devolucion::class);
    }
}