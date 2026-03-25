<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function catalogo()
{
    $query = Producto::query();

    // FILTRO por categoría o subcategoría
    if (request('categoria')) {
        $categoria = request('categoria');

        $query->whereHas('categoria', function($q) use ($categoria) {
            $q->where('nombre', $categoria)
              ->orWhereHas('padre', function($q2) use ($categoria) {
                  $q2->where('nombre', $categoria);
              });
        });
    }

    $products = $query->paginate(12);

    return view('catalogo', compact('products'));
}
}