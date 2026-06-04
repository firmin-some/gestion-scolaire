<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ParentController;

// Page d'accueil → redirige vers dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Routes authentification / inscription
require __DIR__.'/auth.php';

// Routes protégées
Route::middleware(['auth'])->group(function () {

    // Dashboard général
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Notes : accès lecture Enseignant + Gestionnaire
    Route::middleware(['role:Enseignant|Gestionnaire'])->group(function () {
        Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
        Route::get('/notes/eleves', [NoteController::class, 'getEleves'])->name('notes.eleves');
        Route::get('/notes/moyennes', [NoteController::class, 'moyennes'])->name('notes.moyennes');
        Route::get('/notes/classement', [NoteController::class, 'classement'])->name('notes.classement');
        Route::get('/notes/bulletin-pdf', [NoteController::class, 'bulletinPdf'])->name('notes.bulletin-pdf');
    });

    // Notes : écriture Enseignant uniquement
    Route::middleware(['role:Enseignant'])->group(function () {
        Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    });

    // Parent + Enseignant : gestion de leurs enfants
    Route::middleware(['role:Parent|Enseignant'])->prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('dashboard');
        Route::get('/inscrire', [ParentController::class, 'createEleve'])->name('inscrire');
        Route::post('/inscrire', [ParentController::class, 'storeEleve'])->name('inscrire.store');
        Route::get('/notes/{eleve}', [ParentController::class, 'notes'])->name('notes');
        Route::get('/bulletin/{eleve}/pdf', [ParentController::class, 'bulletinPdf'])->name('bulletin.pdf');
        Route::get('/paiements/{eleve}', [ParentController::class, 'paiements'])->name('paiements');
        Route::get('/paiements/{eleve}/payer', [ParentController::class, 'formPaiement'])->name('paiements.form');
        Route::post('/paiements/{eleve}/payer', [ParentController::class, 'storePaiement'])->name('paiements.store');
        Route::get('/paiements/{paiement}/recu', [ParentController::class, 'recuPdf'])->name('paiements.recu');
    });

    // Élèves : accès lecture Gestionnaire + Enseignant
    Route::middleware(['role:Enseignant|Gestionnaire'])->group(function () {
        Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
        Route::get('/eleves/{eleve}', [EleveController::class, 'show'])->name('eleves.show');
    });

    // Gestionnaire : administration globale
    Route::middleware(['role:Gestionnaire'])->group(function () {
        Route::resource('classes', ClasseController::class)->parameters(['classes' => 'classe']);

        Route::resource('eleves', EleveController::class)
             ->only(['create', 'store', 'edit', 'update', 'destroy'])
             ->parameters(['eleves' => 'eleve']);

        Route::resource('paiements', PaiementController::class);
        Route::get('/paiements/{paiement}/recu-pdf', [PaiementController::class, 'recuPdf'])
             ->name('paiements.recu-pdf');
        Route::patch('/paiements/{paiement}/valider', [PaiementController::class, 'valider'])
             ->name('paiements.valider');
        Route::patch('/paiements/{paiement}/rejeter', [PaiementController::class, 'rejeter'])
             ->name('paiements.rejeter');

        Route::resource('enseignants', EnseignantController::class);

        Route::get('/gestionnaire/parents', [ParentController::class, 'index'])
             ->name('gestionnaire.parents.index');
    });
});