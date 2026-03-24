<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'padre_id',
        'nombre',
        'descripcion',
        'slug'
    ];

    public function padre()
    {
        return $this->belongsTo(Categoria::class, 'padre_id');
    }

    public function hijos()
    {
        return $this->hasMany(Categoria::class, 'padre_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}