<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    
    // Routes pour les salariés
    Route::middleware(['role:salarie,rh,admin'])->prefix('salarie')->group(function () {
        // Ajouter vos routes pour les salariés ici
    });
    
    // Routes pour les RH
    Route::middleware(['role:rh,admin'])->prefix('rh')->group(function () {
        // Ajouter vos routes pour les RH ici
    });
    
    // Routes pour les administrateurs
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Ajouter vos routes pour les administrateurs ici
    });
});