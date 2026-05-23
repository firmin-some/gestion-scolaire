<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Page d'accueil → redirige vers dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/// Inscription publique pour les parents uniquement
Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
     ->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

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
          Route::patch('/paiements/{paiement}/valider', [PaiementController::class, 'valider'])->name('paiements.valider');
    Route::patch('/paiements/{paiement}/rejeter', [PaiementController::class, 'rejeter'])->name('paiements.rejeter');
});
Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Déconnexion
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        // Classes
        Route::resource('classes', ClasseController::class);

        // Élèves
Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
Route::get('/eleves/create', [EleveController::class, 'create'])->name('eleves.create');
Route::post('/eleves', [EleveController::class, 'store'])->name('eleves.store');
Route::get('/eleves/{eleve}', [EleveController::class, 'show'])->name('eleves.show');
Route::get('/eleves/{eleve}/edit', [EleveController::class, 'edit'])->name('eleves.edit');
Route::put('/eleves/{eleve}', [EleveController::class, 'update'])->name('eleves.update');
Route::delete('/eleves/{eleve}', [EleveController::class, 'destroy'])->name('eleves.destroy');

        // Paiements
        Route::resource('paiements', PaiementController::class);
        Route::get('/paiements/{paiement}/recu-pdf', [PaiementController::class, 'recuPdf'])
             ->name('paiements.recu-pdf');

        // Enseignants
        Route::resource('enseignants', EnseignantController::class);
    });
    // Routes Parent
Route::middleware(['role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('dashboard');
    Route::get('/inscrire', [ParentController::class, 'createEleve'])->name('inscrire');
    Route::post('/inscrire', [ParentController::class, 'storeEleve'])->name('inscrire.store');
    Route::get('/notes/{eleve}', [ParentController::class, 'notes'])->name('notes');
    Route::get('/paiements/{eleve}', [ParentController::class, 'paiements'])->name('paiements');
     Route::get('/paiements/{eleve}/payer', [ParentController::class, 'formPaiement'])->name('paiements.form');
    Route::post('/paiements/{eleve}/payer', [ParentController::class, 'storePaiement'])->name('paiements.store');
    Route::get('/paiements/{paiement}/recu', [ParentController::class, 'recuPdf'])->name('paiements.recu');
});

// Routes d'authentification (login, logout...)
require __DIR__.'/auth.php';