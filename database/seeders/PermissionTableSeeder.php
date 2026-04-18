<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',

           'projet-liste',
           'projet-ajouter',
           'projet-modifier',
           'projet-supprimer',

           'fiche_projet-liste',
           'fiche_projet-ajouter',
           'fiche_projet-modifier',
           'fiche_projet-supprimer',

           'departement-liste',
           'departement-ajouter',
           'departement-modifier',
           'departement-supprimer',

           'ligne-liste',
           'ligne-ajouter',
           'ligne-modifier',
           'ligne-supprimer',

           'arret-liste',
           'arret-ajouter',
           'arret-modifier',
           'arret-supprimer',

           'bus-liste',
           'bus-ajouter',
           'bus-modifier',
           'bus-supprimer',

           'conducteur-liste',
           'conducteur-ajouter',
           'conducteur-modifier',
           'conducteur-supprimer',

           'position-liste',
           'position-ajouter',
           'position-modifier',
           'position-supprimer'


        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
