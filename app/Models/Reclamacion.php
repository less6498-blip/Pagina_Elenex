<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Reclamacion extends Model
{
    use HasFactory;
 
    protected $table = 'reclamaciones';
 
    protected $fillable = [
        'codigo',
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'correo',
        'es_menor',
        'direccion',
        'tipo_bien',
        'monto_reclamado',
        'descripcion_bien',
        'tipo_reclamo',
        'detalle_reclamo',
        'pedido_consumidor',
        'estado',
        'respuesta',
        'fecha_respuesta',
        'ip_registro',
    ];
 
    protected $casts = [
        'es_menor'        => 'boolean',
        'monto_reclamado' => 'decimal:2',
        'fecha_respuesta' => 'datetime',
    ];
 
    /**
     * Nombre completo del reclamante.
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";
    }
 
    /**
     * Scope para filtrar por estado.
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'PENDIENTE');
    }
 
    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'EN_PROCESO');
    }
}