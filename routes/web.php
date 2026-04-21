<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CheckoutController;

// Página principal 📌
Route::get('/', [HomeController::class, 'index']);

// Tiendas 🏬
Route::get('/tiendas', [TiendaController::class, 'index'])->name('tiendas.index');


// 🧑 Clientes (CRUD)
Route::resource('clientes', ClienteController::class);

// 📦 Productos 

Route::get('/catalogo/{categoria?}', [ProductoController::class, 'catalogo'])
    ->name('productos.catalogo'); // 
Route::get('/productos/{slug}', [ProductoController::class, 'show'])
    ->name('productos.show');
    
// 🧾 Pedidos (CRUD)
Route::resource('pedidos', PedidoController::class);

// 🔎 Buqueda de productos
Route::get('/api/productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

// 🎇 New arrivals
Route::get('/new-arrivals', [App\Http\Controllers\HomeController::class, 'newArrivals'])
    ->name('productos.newArrivals'); //

// 👕👖 Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/procesar', [CheckoutController::class, 'procesar'])->name('checkout.procesar');
Route::get('/checkout/confirmacion/{codigo}', [CheckoutController::class, 'confirmacion'])->name('checkout.confirmacion');