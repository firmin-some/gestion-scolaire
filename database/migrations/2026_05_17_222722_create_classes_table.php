<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');           // Ex: CP1 A
            $table->string('niveau');        // CP1, CP2, CE1...
            $table->string('enseignant');    // Nom du titulaire
            $table->integer('frais');        // Frais annuels en FCFA
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};