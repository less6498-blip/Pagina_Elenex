<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;

Route::get('/', [HomeController::class, 'index']);

// Tiendas
Route::get('/tiendas', [TiendaController::class, 'index'])->name('tiendas.index');