<?php

use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

// Public frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [HomeController::class, 'productos'])->name('productos');
Route::get('/producto/{id}', [HomeController::class, 'productoDetalle'])->name('producto.detalle');
Route::get('/cocineros', [HomeController::class, 'cocineros'])->name('cocineros');
Route::get('/cocinero/{id}', [HomeController::class, 'cocineroDetalle'])->name('cocinero.detalle');
