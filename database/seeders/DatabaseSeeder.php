<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appelle tous les seeder nécessaires ici
        $this->call([
            VilleSeeder::class, // on ajoute ton seeder de villes
        ]);

        // Tu pourras plus tard ajouter ici :
        // LigneSeeder::class,
        // ArretSeeder::class,
        // etc.
    }
}
