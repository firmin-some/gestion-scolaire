<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Crée un utilisateur de test
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ✅ Ajout des rôles et permissions
        $this->call(RoleSeeder::class);

        // ✅ Création des trois comptes avec ton nom et rôles

        // Parent
        $parent = User::create([
            'name' => 'SOME Firmin',
            'email' => 'parent@example.com',
            'password' => 'password123', // Le casting 'hashed' va le hasher automatiquement
            'role' => 'parent',
        ]);
        $parent->assignRole('parent');

        // Enseignant
        $enseignant = User::create([
            'name' => 'SOME Firmin',
            'email' => 'enseignant@example.com',
            'password' => 'password123', // Le casting 'hashed' va le hasher automatiquement
            'role' => 'enseignant',
        ]);
        $enseignant->assignRole('enseignant');

        // Gestionnaire
        $gestionnaire = User::create([
            'name' => 'SOME Firmin',
            'email' => 'gestionnaire@example.com',
            'password' => 'password123', // Le casting 'hashed' va le hasher automatiquement
            'role' => 'gestionnaire',
        ]);
        $gestionnaire->assignRole('gestionnaire');
    }
}
