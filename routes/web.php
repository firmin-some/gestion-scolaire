<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EnseignantController;

// Page d'accueil → redirige vers dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Désactiver l'inscription publique
Route::get('/register', function () {
    abort(403, 'Inscription non autorisée. Contactez l\'administrateur.');
})->name('register');
Route::post('/register', function () {
    abort(403, 'Inscription non autorisée.');
});

// Routes protégées
Route::middleware(['auth'])->group(function () {

    // ---- Accessible à TOUS (gestionnaire + enseignant) ----
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Notes
    Route::get('/notes', [NoteController::class, 'index'])
         ->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])
         ->name('notes.store');
    Route::get('/notes/eleves', [NoteController::class, 'getEleves'])
         ->name('notes.eleves');
    Route::get('/notes/moyennes', [NoteController::class, 'moyennes'])
         ->name('notes.moyennes');
    Route::get('/notes/classement', [NoteController::class, 'classement'])
         ->name('notes.classement');
    Route::get('/notes/bulletin-pdf', [NoteController::class, 'bulletinPdf'])
         ->name('notes.bulletin-pdf');

    // ---- Accessible au GESTIONNAIRE uniquement ----
    Route::middleware(['role:gestionnaire'])->group(function () {

        // Classes
        Route::resource('classes', ClasseController::class);

        // Élèves
        Route::resource('eleves', EleveController::class);

        // Paiements
        Route::resource('paiements', PaiementController::class);
        Route::get('/paiements/{paiement}/recu-pdf', [PaiementController::class, 'recuPdf'])
             ->name('paiements.recu-pdf');

        // Enseignants
        Route::resource('enseignants', EnseignantController::class);
    });
});

// Routes d'authentification (login, logout...)
require __DIR__.'/auth.php';