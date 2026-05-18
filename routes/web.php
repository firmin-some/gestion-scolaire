<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\NoteController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('classes', ClasseController::class);
    Route::resource('eleves', EleveController::class);
    Route::resource('paiements', PaiementController::class);

    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/eleves', [NoteController::class, 'getEleves'])->name('notes.eleves');
    Route::get('/notes/moyennes', [NoteController::class, 'moyennes'])->name('notes.moyennes');
    Route::get('/notes/classement', [NoteController::class, 'classement'])->name('notes.classement');
    Route::get('/paiements/{paiement}/recu-pdf', [PaiementController::class, 'recuPdf'])
     ->name('paiements.recu-pdf');
Route::get('/notes/bulletin-pdf', [NoteController::class, 'bulletinPdf'])
     ->name('notes.bulletin-pdf');
});

require __DIR__.'/auth.php';