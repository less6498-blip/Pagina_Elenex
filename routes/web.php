<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReclamacionController;
use App\Http\Controllers\Admin\AdminProductoController;
use App\Http\Controllers\Admin\AdminAuthController;

// 👤 Login admin (público)
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// 👨‍💻 Panel admin (protegido)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [AdminProductoController::class, 'dashboard'])->name('dashboard');
    Route::get('/productos', [AdminProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/plantilla', [AdminProductoController::class, 'descargarPlantilla'])->name('productos.plantilla');
    Route::post('/productos/importar', [AdminProductoController::class, 'importar'])->name('productos.importar');
    Route::get('/productos/crear', [AdminProductoController::class, 'crear'])->name('productos.crear');
    Route::post('/productos', [AdminProductoController::class, 'guardar'])->name('productos.guardar');
    Route::get('/productos/{id}/editar', [AdminProductoController::class, 'editar'])->name('productos.editar');
    Route::put('/productos/{id}', [AdminProductoController::class, 'actualizar'])->name('productos.actualizar');
    Route::delete('/productos/{id}', [AdminProductoController::class, 'eliminar'])->name('productos.eliminar');
    Route::delete('/variantes/{id}', [AdminProductoController::class, 'eliminarVariante'])->name('variantes.eliminar');
    Route::delete('/imagenes/{id}', [AdminProductoController::class, 'eliminarImagen'])->name('imagenes.eliminar');
    Route::get('/pedidos', [AdminProductoController::class, 'pedidos'])->name('pedidos.index');
    Route::patch('/pedidos/{id}/estado', [AdminProductoController::class, 'actualizarEstadoPedido'])->name('pedidos.estado');
});



// 📌 Página principal 
Route::get('/', [HomeController::class, 'index']);

// 🏬 Tiendas 
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

// 👗 Woman
Route::get('/woman', [App\Http\Controllers\HomeController::class, 'woman'])->name('productos.woman');

// 👦 Kids
Route::get('/kids', [App\Http\Controllers\HomeController::class, 'kids'])->name('productos.kids');

// 🌊 After Wave
Route::get('/after-wave', [App\Http\Controllers\HomeController::class, 'afterWave'])->name('productos.afterWave');

// 👕👖 Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/procesar', [CheckoutController::class, 'procesar'])->name('checkout.procesar');
Route::get('/checkout/confirmacion/{codigo}', [CheckoutController::class, 'confirmacion'])->name('checkout.confirmacion');

// 📖 Libro de reclamaciones
Route::get('/libro-de-reclamaciones', [ReclamacionController::class, 'create'])
    ->name('reclamaciones.create');
Route::post('/libro-de-reclamaciones', [ReclamacionController::class, 'store'])
    ->name('reclamaciones.store');

// ❓ Preguntas frecuentes
Route::get('/preguntas', function () {
    return view('preguntas');
    })->name('faq');

// 🧿 Política privacidad
Route::get('/politica', function () {
    return view('politica');
    })->name('privacy');

// ❗ Terminos y condiciones
Route::get('/terminos', function () {
    return view('terminos');
})->name('terms');