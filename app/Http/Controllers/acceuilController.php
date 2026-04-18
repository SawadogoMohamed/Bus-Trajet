<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ligne;
use Illuminate\Support\Facades\Cache;
use App\Models\Ville;
use App\Models\Visitor;
use Illuminate\Http\Request;

class acceuilController extends Controller
{

    /**
     * Affiche le tableau de bord avec les villes pour la sélection.
     */
    public function index()
    {
        $villes = Ville::all();

        // 🔢 Bus actifs
        $busActifs = Bus::where('etat', 'actif')->count();
        $nbLignes = Ligne::count();

        // 🔢 Visiteurs en ligne
        $visiteursEnLigne = Visitor::where(
            'last_activity',
            '>=',
            now()->subMinutes(2)
        )->count();

        return view('acceuil', compact(
            'villes',
            'nbLignes',
            'busActifs',
            'visiteursEnLigne'
        ));
    }
}