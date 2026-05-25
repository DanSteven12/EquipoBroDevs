<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación pública y registro
Route::prefix('auth')->group(function () {
    Route::post('registro', [AutenticacionController::class, 'registrarse']);
    Route::post('login', [AutenticacionController::class, 'iniciarSesion']);

    // Rutas protegidas de autenticación y perfil
    Route::middleware('jwt.verificar')->group(function () {
        Route::post('logout', [AutenticacionController::class, 'cerrarSesion']);
        Route::post('refresh', [AutenticacionController::class, 'refrescarToken']);
        
        Route::get('perfil', [AutenticacionController::class, 'obtenerPerfil']);
        Route::put('perfil', [AutenticacionController::class, 'actualizarPerfil']);
    });
});

// Rutas de eventos (Lectura pública, Escritura protegida)
Route::get('eventos', [EventoController::class, 'index']);
Route::get('eventos/{id}', [EventoController::class, 'show']);

Route::middleware('jwt.verificar')->group(function () {
    Route::post('eventos', [EventoController::class, 'store']);
    Route::put('eventos/{id}', [EventoController::class, 'update']);
    Route::delete('eventos/{id}', [EventoController::class, 'destroy']);
});
