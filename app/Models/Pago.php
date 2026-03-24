<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'metodo_pago',
        'estado_pago',
        'proveedor',
        'estado',
        'monto',
        'fecha_pago'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}