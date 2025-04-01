<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes statiques pour afficher toutes les vues front-end
| du système de gestion des congés
|
*/

// Page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Redirection de la page d'accueil vers la page de connexion
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes pour les pages Salarié
Route::get('/employee/solde', function () {
    return view('employee.solde_conges');
})->name('employee.solde');

Route::get('/employee/demande', function () {
    return view('employee.demande_conges');
})->name('employee.demande');

Route::get('/employee/historique', function () {
    return view('employee.historique');
})->name('employee.historique');

// Routes pour les pages RH
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

// Routes pour les pages Admin
Route::get('/admin/gestion-rh', function () {
    return view('admin.gestion_rh');
})->name('admin.gestion_rh');

Route::get('/admin/statistiques', function () {
    return view('admin.statistiques');
})->name('admin.statistiques');