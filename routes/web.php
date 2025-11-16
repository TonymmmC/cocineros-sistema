<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ClienteController;
use Illuminate\Support\Facades\Route;

// Public frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [HomeController::class, 'productos'])->name('productos');
Route::get('/producto/{id}', [HomeController::class, 'productoDetalle'])->name('producto.detalle');
Route::get('/cocineros', [HomeController::class, 'cocineros'])->name('cocineros');
Route::get('/cocinero/{id}', [HomeController::class, 'cocineroDetalle'])->name('cocinero.detalle');

// Client authentication routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [ClienteController::class, 'showLoginForm'])->name('cliente.login');
    Route::post('/login', [ClienteController::class, 'login'])->name('cliente.login.post');
    Route::get('/register', [ClienteController::class, 'showRegisterForm'])->name('cliente.register');
    Route::post('/register', [ClienteController::class, 'register'])->name('cliente.register.post');
});

// Client protected routes (authenticated only)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [ClienteController::class, 'logout'])->name('cliente.logout');
    Route::get('/perfil', [ClienteController::class, 'perfil'])->name('cliente.perfil');
    Route::put('/perfil', [ClienteController::class, 'updatePerfil'])->name('cliente.perfil.update');
    Route::get('/mis-pedidos', [ClienteController::class, 'pedidos'])->name('cliente.pedidos');
    Route::get('/favoritos', [ClienteController::class, 'favoritos'])->name('cliente.favoritos');
});
