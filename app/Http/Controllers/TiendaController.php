<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiendaController extends Controller
{
    public function index()
    {
        return view('tiendas'); // resources/views/tiendas.blade.php
    }
}
