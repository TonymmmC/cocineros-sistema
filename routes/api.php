<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CocineroController;
use App\Http\Controllers\Api\ProductoController;
use Illuminate\Support\Facades\Route;

// Rutas públicas (sin autenticación)
Route::prefix('v1')->group(function () {
    // Autenticación
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Categorías (público)
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::get('/categorias/{id}', [CategoriaController::class, 'show']);

    // Productos (público)
    Route::get('/productos', [ProductoController::class, 'index']);
    Route::get('/productos/{id}', [ProductoController::class, 'show']);
    Route::get('/productos/categoria/{categoriaId}', [ProductoController::class, 'byCategoria']);
    Route::get('/productos/search', [ProductoController::class, 'search']);

    // Cocineros (público)
    Route::get('/cocineros', [CocineroController::class, 'index']);
    Route::get('/cocineros/{id}', [CocineroController::class, 'show']);
    Route::get('/cocineros/{id}/productos', [CocineroController::class, 'productos']);
});

// Rutas protegidas (requieren autenticación)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Productos (solo cocineros)
    Route::middleware('role:cocinero')->group(function () {
        Route::post('/productos', [ProductoController::class, 'store']);
        Route::put('/productos/{id}', [ProductoController::class, 'update']);
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);
        Route::patch('/productos/{id}/toggle-disponibilidad', [ProductoController::class, 'toggleDisponibilidad']);
    });

    // Cocineros (solo cocineros)
    Route::middleware('role:cocinero')->group(function () {
        Route::put('/cocineros/perfil', [CocineroController::class, 'updatePerfil']);
        Route::patch('/cocineros/toggle-disponibilidad', [CocineroController::class, 'toggleDisponibilidad']);
    });
});
