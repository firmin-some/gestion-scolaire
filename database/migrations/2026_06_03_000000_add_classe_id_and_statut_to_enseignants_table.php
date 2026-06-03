<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->foreignId('classe_id')
                  ->nullable()
                  ->after('code')
                  ->constrained('classes')
                  ->nullOnDelete();

            $table->enum('statut', ['titulaire', 'secondaire'])
                  ->default('secondaire')
                  ->after('classe_id');
        });
    }

    public function down(): void
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->dropForeign(['classe_id']);
            $table->dropColumn(['classe_id', 'statut']);
        });
    }
};
