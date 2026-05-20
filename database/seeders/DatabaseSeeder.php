<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('password123'),
        ]);
        $parent->assignRole('Parent');

        // Enseignant
        $enseignant = User::create([
            'name' => 'SOME Firmin',
            'email' => 'enseignant@example.com',
            'password' => Hash::make('password123'),
        ]);
        $enseignant->assignRole('Enseignant');

        // Gestionnaire
        $gestionnaire = User::create([
            'name' => 'SOME Firmin',
            'email' => 'gestionnaire@example.com',
            'password' => Hash::make('password123'),
        ]);
        $gestionnaire->assignRole('Gestionnaire');
    }
}
