<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Departement;
use App\Models\Ligne;
use App\Models\Ville;
use App\Models\Visitor;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche le tableau de bord avec les villes pour la sélection.
     */
    public function index()
    {
        // Anciennes statistiques (facultatives)
        $users = User::count();
        $departements = Departement::count();

        // Nouvelles données pour la carte
        $villes = Ville::all(); // toutes les villes

        // Retourne la vue avec toutes les données
        return view('dashboards.accueil', compact(
            'users',
            'departements',
            'villes'
        ));

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
