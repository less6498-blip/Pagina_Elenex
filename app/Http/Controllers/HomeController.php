<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; 
use App\Models\Categoria;

class HomeController extends Controller
{
    public function index()
    {
        // Traer productos por categoría
        $polos = Producto::whereHas('categoria', fn($q) => $q->where('nombre', 'Polos'))->get();
        $casacas = Producto::whereHas('categoria', fn($q) => $q->where('nombre', 'Casacas'))->get();

        // Traer todas las categorías para el carrusel
        $categorias = Categoria::all();


        // 🔹 Productos nuevos para New Arrivals
        $newArrivals = Producto::where('activo', 1)
            ->where('nuevo', 1)
            ->get();
            
        // Enviar los productos y categorías a la vista
        return view('home', compact('polos', 'casacas', 'categorias', 'newArrivals'));
    }

    
    // Página exclusiva para todos los New Arrivals
    public function newArrivals()
    {
        // Todos los productos nuevos
        $productos = Producto::where('activo', 1)
                             ->where('nuevo', 1)
                             ->get();

        // Enviar a la vista new-arrivals
        return view('new-arrivals', compact('productos'));
    }


    // 👗 Woman
public function woman(Request $request)
{
    $categoria     = $request->get('categoria');
    $queryBusqueda = $request->get('query');

    $query = Producto::with(['variantes.imagenes', 'categoria'])
                     ->where('activo', 1)
                     ->where('seccion', 'woman');

    if ($categoria) {
        $query->whereHas('categoria', function($q) use ($categoria) {
            $q->whereRaw('LOWER(nombre) = ?', [strtolower($categoria)]);
        });
    }

    $productos       = $query->get();
    $todasCategorias = $productos->groupBy(fn($p) => $p->categoria->nombre ?? 'Sin categoría');

    return view('woman', compact('productos', 'todasCategorias', 'categoria', 'queryBusqueda'));
}

// 👦 Kids
public function kids(Request $request)
{
    $categoria     = $request->get('categoria');
    $queryBusqueda = $request->get('query');

    $query = Producto::with(['variantes.imagenes', 'categoria'])
                     ->where('activo', 1)
                     ->where('seccion', 'kids');

    if ($categoria) {
        $query->whereHas('categoria', function($q) use ($categoria) {
            $q->whereRaw('LOWER(nombre) = ?', [strtolower($categoria)]);
        });
    }

    $productos       = $query->get();
    $todasCategorias = $productos->groupBy(fn($p) => $p->categoria->nombre ?? 'Sin categoría');

    return view('kids', compact('productos', 'todasCategorias', 'categoria', 'queryBusqueda'));
}

// 🌊 After Wave
public function afterWave(Request $request)
{
    $productos = Producto::with(['variantes.imagenes', 'categoria'])
                         ->where('activo', 1)
                         ->where('seccion', 'after_wave')
                         ->get();

    return view('after-wave', compact('productos'));
}

}