<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'pedido_id', 'culqi_charge_id', 'monto',
        'moneda', 'estado', 'marca_tarjeta',
        'ultimos_digitos', 'respuesta_completa',
    ];
}