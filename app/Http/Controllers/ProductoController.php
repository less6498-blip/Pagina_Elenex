<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    // 🔹 Mostrar el catálogo de productos
    public function catalogo(Request $request, $categoria = null)
    {
        $queryBusqueda = $request->get('query');

        // 🔹 TODAS las categorías
        $todasCategorias = Producto::with('categoria')
            ->where('activo', 1)
            ->get()
            ->groupBy(function($producto) {
                return $producto->categoria->nombre ?? 'Sin categoría';
            });

        // 🔹 QUERY base
        $query = Producto::with('categoria')
            ->where('activo', 1);

        // 🔹 filtro por categoría
        if ($categoria) {
            $query->whereHas('categoria', function ($q) use ($categoria) {
                $q->whereRaw('LOWER(nombre) = ?', [strtolower($categoria)]);
            });
        }

        // 🔥 FILTRO POR BUSQUEDA (IMPORTANTE)
        if (!empty($queryBusqueda)) {
            $palabras = explode(' ', $queryBusqueda);

            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where('nombre', 'like', '%' . $palabra . '%');
                }
            });
        }

        $productos = $query->get();

        return view('catalogo', compact('productos', 'todasCategorias', 'categoria', 'queryBusqueda'));
    }

    // 🔹 Búsqueda de productos para el header
    public function buscar(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (!$query) {
            return response()->json([]);
        }

        // 🔹 Normalizar plural a singular
        $query = $this->normalizarBusqueda($query);

        // 🔹 Consulta productos activos con primera imagen
        $productos = Producto::with(['variantes.imagenes' => function($q) {
                $q->orderBy('orden');
            }])
            ->where('activo', 1)
            ->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($query) . '%'])
            ->take(20)
            ->get(['id', 'nombre', 'precio']);

        // 🔹 Asignar imagen principal
        $productos->transform(function($p) {
            $imagen = null;
            if ($p->variantes->first() && $p->variantes->first()->imagenes->first()) {
                $imagen = $p->variantes->first()->imagenes->first()->ruta;
            }
            $p->imagen = $imagen ? asset('img/' . $imagen) : asset('img/default.webp');
            return $p;
        });

        return response()->json($productos);
    }

    // 🔹 Mostrar detalle de un producto
    public function show($id)
{
    $producto = Producto::with(['variantes.imagenes' => function($q) {
        $q->orderBy('orden');
    }])->findOrFail($id);

    $productosSimilares = Producto::with(['variantes.imagenes'])
        ->where('activo', 1)
        ->where('categoria_id', $producto->categoria_id)
        ->where('id', '!=', $producto->id)
        ->take(10)
        ->get();

    return view('detalle', compact('producto', 'productosSimilares'));
}

    // 🔹 Función para normalizar plurales a singular
    private function normalizarBusqueda($palabra)
    {
        $palabra = strtolower($palabra);

        $plurales = [
            'polos' => 'polo',
            'camisas' => 'camisa',
            'pantalones' => 'pantalon',
            'casacas' => 'casaca',
            'chalecos' => 'chaleco',
            'poleras' => 'polera',
            'joggers' => 'jogger',
            'bermudas' => 'bermuda',
            'shorts' => 'short',
            'accesorios' => 'accesorio',
            'bividis' => 'bividi'
        ];

        return $plurales[$palabra] ?? $palabra;
    }
}