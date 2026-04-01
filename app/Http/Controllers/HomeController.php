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
}