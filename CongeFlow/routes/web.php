<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalarieController;
use App\Http\Controllers\ProfileController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes protégées
Route::middleware(['auth'])->group(function () {
    // Routes pour le profil utilisateur
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
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
        
        // Routes pour la gestion des congés
        Route::get('/conges', [App\Http\Controllers\CongeController::class, 'index'])->name('conges.index');
        Route::get('/conges/create', [App\Http\Controllers\CongeController::class, 'create'])->name('conges.create');
        Route::post('/conges', [App\Http\Controllers\CongeController::class, 'store'])->name('conges.store');
        Route::get('/conges/{demande}', [App\Http\Controllers\CongeController::class, 'show'])->name('conges.show');
        Route::get('/conges/{demande}/edit', [App\Http\Controllers\CongeController::class, 'edit'])->name('conges.edit');
        Route::put('/conges/{demande}', [App\Http\Controllers\CongeController::class, 'update'])->name('conges.update');
        Route::delete('/conges/{demande}', [App\Http\Controllers\CongeController::class, 'destroy'])->name('conges.destroy');
        Route::post('/conges/{demande}/cancel', [App\Http\Controllers\CongeController::class, 'cancel'])->name('conges.cancel');
        
        // Route Ajax pour récupérer les demandes
        Route::get('/api/conges', [App\Http\Controllers\CongeController::class, 'getDemandes'])->name('api.conges.index');
    });

    // Routes pour les pages RH
    Route::middleware(['role:rh'])->group(function () {
        // Gestion des salariés
        Route::get('/hr/gestion-salaries', [SalarieController::class, 'index'])->name('hr.salaries.index');
        Route::get('/hr/salaries/create', [SalarieController::class, 'create'])->name('hr.salaries.create');
        Route::post('/hr/salaries', [SalarieController::class, 'store'])->name('hr.salaries.store');
        Route::get('/hr/salaries/{salarie}/edit', [SalarieController::class, 'edit'])->name('hr.salaries.edit');
        Route::put('/hr/salaries/{salarie}', [SalarieController::class, 'update'])->name('hr.salaries.update');
        Route::delete('/hr/salaries/{salarie}', [SalarieController::class, 'destroy'])->name('hr.salaries.destroy');

        Route::get('/hr/gestion-conges', [App\Http\Controllers\CongeController::class, 'gestionConges'])->name('hr.gestion_conges');

        Route::get('/hr/configuration-conges', function () {
            return view('hr.configuration_conges');
        })->name('hr.configuration_conges');

        Route::get('/hr/suivi-absences', function () {
            return view('hr.suivi_absences');
        })->name('hr.suivi_absences');
        
        // Route pour mettre à jour le statut d'une demande de congé
        Route::post('/conges/{id}/update-statut', [App\Http\Controllers\CongeController::class, 'updateStatutDemande'])->name('conges.update-statut');
        
        // Route pour le filtrage AJAX des demandes
        Route::post('/api/conges/filter', [App\Http\Controllers\CongeController::class, 'filter'])->name('api.conges.filter');
    });

    // Routes pour les pages Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/gestion-rh', function () {
            return view('admin.gestion_rh');
        })->name('admin.gestion_rh');

        Route::get('/admin/statistiques', [App\Http\Controllers\StatistiquesController::class, 'index'])->name('admin.statistiques');
        
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

Route::get('/demo/decider-demande', function () {
    return view('examples.decider_demande');
})->name('demo.decider');

// Routes de test pour l'upload de photos
Route::get('/test/upload', [App\Http\Controllers\PhotoController::class, 'showForm'])->name('test.upload.form');
Route::post('/test/upload', [App\Http\Controllers\PhotoController::class, 'upload'])->name('test.upload');