<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('enseignants', 'prenom')) {
            Schema::table('enseignants', function (Blueprint $table) {
                $table->string('prenom')->after('nom')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('enseignants', 'prenom')) {
            Schema::table('enseignants', function (Blueprint $table) {
                $table->dropColumn('prenom');
            });
        }
    }
};