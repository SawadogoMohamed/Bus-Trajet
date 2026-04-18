<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ville;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        Ville::create(['nom' => 'Ouagadougou', 'latitude' => 12.3714, 'longitude' => -1.5197]);
        Ville::create(['nom' => 'Bobo-Dioulasso', 'latitude' => 11.1771, 'longitude' => -4.2979]);
        Ville::create(['nom' => 'Koudougou', 'latitude' => 12.251, 'longitude' => -2.361]);
    }
}
