<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'guest_nombre', 'guest_email', 'guest_telefono',
        'envio_departamento', 'envio_provincia', 'envio_distrito',
        'envio_direccion', 'envio_referencia',
        'subtotal', 'costo_envio', 'total',
        'estado', 'estado_pago', 'metodo_pago', 'codigo_orden',
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}