<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes'; // 👈 SOLUCIÓN

    protected $fillable = ['variante_id', 'ruta', 'orden'];

    public function variante()
    {
        return $this->belongsTo(Variante::class);
    }
}