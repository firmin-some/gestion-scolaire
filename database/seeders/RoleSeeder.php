<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Création des rôles
        $parent = Role::create(['name' => 'parent']);
        $enseignant = Role::create(['name' => 'enseignant']);
        $gestionnaire = Role::create(['name' => 'gestionnaire']);

        // Création des permissions
        Permission::create(['name' => 'inscrire eleve']);
        Permission::create(['name' => 'voir notes']);
        Permission::create(['name' => 'voir bulletin']);
        Permission::create(['name' => 'payer frais']);
        Permission::create(['name' => 'modifier notes']);
        Permission::create(['name' => 'gerer finances']);

        // Attribution des permissions
        $parent->givePermissionTo(['inscrire eleve', 'voir notes', 'voir bulletin', 'payer frais']);
        $enseignant->givePermissionTo(['modifier notes']);
        $gestionnaire->givePermissionTo(['gerer finances']);
    }
}
