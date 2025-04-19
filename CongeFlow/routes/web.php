<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes protégées
Route::middleware(['auth'])->group(function () {
    // Routes pour les pages Salarié
    Route::middleware(['role:salarie,rh,admin'])->group(function () {
        Route::get('/employee/solde', function () {
            return view('employee.solde_conges');
        })->name('employee.solde');

        Route::get('/employee/demande', function () {
            return view('employee.demande_conges');
        })->name('employee.demande');

        Route::get('/employee/historique', function () {
            return view('employee.historique');
        })->name('employee.historique');
    });

    // Routes pour les pages RH
    Route::middleware(['role:rh,admin'])->group(function () {
        Route::get('/hr/gestion-conges', function () {
            return view('hr.gestion_conges');
        })->name('hr.gestion_conges');

        Route::get('/hr/gestion-salaries', function () {
            return view('hr.gestion_salaries');
        })->name('hr.gestion_salaries');

        Route::get('/hr/configuration-conges', function () {
            return view('hr.configuration_conges');
        })->name('hr.configuration_conges');

        Route::get('/hr/suivi-absences', function () {
            return view('hr.suivi_absences');
        })->name('hr.suivi_absences');
    });

    // Routes pour les pages Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/gestion-rh', function () {
            return view('admin.gestion_rh');
        })->name('admin.gestion_rh');

        Route::get('/admin/statistiques', function () {
            return view('admin.statistiques');
        })->name('admin.statistiques');
        
        // Routes pour la gestion des utilisateurs RH
        Route::prefix('admin/rh')->name('admin.rh.')->group(function () {
            Route::get('/', [App\Http\Controllers\RHController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\RHController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\RHController::class, 'store'])->name('store');
            Route::get('/{rh}/edit', [App\Http\Controllers\RHController::class, 'edit'])->name('edit');
            Route::put('/{rh}', [App\Http\Controllers\RHController::class, 'update'])->name('update');
            Route::delete('/{rh}', [App\Http\Controllers\RHController::class, 'destroy'])->name('destroy');
        });
    });
});