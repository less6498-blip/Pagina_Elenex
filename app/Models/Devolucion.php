<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'detalle_pedido_id',
        'motivo',
        'estado',
        'monto_reembolso',
        'descripcion'
    ];

    public function detallePedido()
    {
        return $this->belongsTo(DetallePedido::class);
    }
}