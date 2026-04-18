<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerifierDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verifier-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $aujourdhui = now()->toDateString(); // Date du jour au format 'Y-m-d'

    // Remplacez 'MaTable' par le nom de votre table
    $dates = DB::table('fiche_partenaires')->whereDate('rendez_vous', $aujourdhui)->get();

    if ($dates->isNotEmpty()) {
        // Émettre un signal ou effectuer d'autres actions en cas de correspondance
        Log::info('Dates correspondantes trouvées aujourd\'hui !');
    }
}

}
