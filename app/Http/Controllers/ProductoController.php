<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    // 🔹 Mostrar el catálogo de productos
   public function catalogo($categoria = null)
{
    // 🔹 TODAS las categorías (para el sidebar)
    $todasCategorias = Producto::with('categoria')
        ->where('activo', 1)
        ->get()
        ->groupBy(function($producto) {
            return $producto->categoria->nombre ?? 'Sin categoría';
        });

    // 🔹 QUERY base
    $query = Producto::with('categoria')
        ->where('activo', 1);

    // 🔥 filtro por categoría
    if ($categoria) {
        $query->whereHas('categoria', function ($q) use ($categoria) {
            $q->whereRaw('LOWER(nombre) = ?', [strtolower($categoria)]);
        });
    }

    $productos = $query->get();

    return view('catalogo', compact('productos', 'todasCategorias', 'categoria'));
}



     public function buscar(Request $request)
{
    $query = $request->get('q', '');

    $productos = Producto::query()
        ->where('activo', 1)
        ->where('nombre', 'like', "%{$query}%")
        ->take(20) // máximo 20 resultados
        ->get(['id', 'nombre', 'precio', 'imagen', 'slug']); // campos que necesitas

    // Asegúrate de poner la URL completa de la imagen si es relativa
    $productos->transform(function($p) {
        $p->imagen = asset('img/' . $p->imagen); // o la carpeta que uses
        return $p;
    });

    return response()->json($productos);
}


    // 🔹 Mostrar detalle de un producto
    public function show($id)
    {
        // Traer el producto actual
        $producto = Producto::findOrFail($id);

        // Traer productos similares (misma categoría) pero excluyendo el producto actual
        $productosSimilares = Producto::where('activo', 1)
            ->where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->take(10)
            ->get();

        // Enviar a la vista detalle
        return view('detalle', compact('producto', 'productosSimilares'));
    }
}