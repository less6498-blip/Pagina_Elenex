<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;

// Página principal
Route::get('/', [HomeController::class, 'index']);

// Tiendas
Route::get('/tiendas', [TiendaController::class, 'index'])->name('tiendas.index');


// 🧑 Clientes (CRUD)
Route::resource('clientes', ClienteController::class);

// 📦 Productos (CRUD)
Route::resource('productos', ProductoController::class);

// 🧾 Pedidos (CRUD)
Route::resource('pedidos', PedidoController::class);