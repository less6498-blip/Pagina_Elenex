<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'marca_id',
        'nombre',
        'talla',
        'color',
        'stock',
        'imagen',
        'slug',
        'precio',
        'activo'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function variantes()
    {
        return $this->hasMany(Variante::class);
    }

    public function detallesCarrito()
    {
        return $this->hasMany(DetalleCarrito::class);
    }
}