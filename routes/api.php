<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\PeliculaSalacineController;
use App\Http\Controllers\SalaCineController;



Route::prefix('peliculas')->group(function () {
    Route::get('/', [PeliculaController::class, 'index']);
    Route::get('/{id}', [PeliculaController::class, 'show']);
    Route::post('/', [PeliculaController::class, 'store']);
    Route::put('/{id}', [PeliculaController::class, 'update']);
    Route::delete('/{id}', [PeliculaController::class, 'destroy']);
});




Route::prefix('salas-cine')->group(function () {
    Route::get('/', [SalaCineController::class, 'index']);
    Route::get('/{id}', [SalaCineController::class, 'show']);
    Route::post('/', [SalaCineController::class, 'store']);
    Route::put('/{id}', [SalaCineController::class, 'update']);
    Route::delete('/{id}', [SalaCineController::class, 'destroy']);
});


Route::prefix('pelicula-salacine')->group(function () {
    Route::get('/', [PeliculaSalacineController::class, 'index']);
    Route::get('/{id}', [PeliculaSalacineController::class, 'show']);
    Route::post('/', [PeliculaSalacineController::class, 'store']);
    Route::put('/{id}', [PeliculaSalacineController::class, 'update']);
    Route::delete('/{id}', [PeliculaSalacineController::class, 'destroy']);
});
