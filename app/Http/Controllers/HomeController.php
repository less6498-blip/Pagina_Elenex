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

        // Enviar los productos y categorías a la vista
        return view('home', compact('polos', 'casacas', 'categorias'));
    }
}