<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct()
    {
        // ð Permissions UNIQUEMENT pour le WEB
        if (!request()->is('api/*')) {

            $this->middleware(
                'permission:position-liste|position-ajouter|position-modifier|position-supprimer',
                ['only' => ['index', 'show']]
            );

            $this->middleware('permission:position-ajouter', ['only' => ['store']]);
            $this->middleware('permission:position-modifier', ['only' => ['updatePosition']]);
            $this->middleware('permission:position-supprimer', ['only' => ['destroy']]);
        }
    }

    /**
     * â Liste des positions (dernières en premier)
     */


    public function index(Request $request)
    {
        $positions = Position::with('bus')->latest()->get();

        // 📱 Si c’est une requête API (Flutter, Postman, etc.)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($positions);
        }

        // 🌐 Sinon → Vue Blade
        return view('positions.index', compact('positions'));
    }

    /**
     * â Formulaire Laravel (WEB)
     */
    public function create()
    {
        $buses = Bus::all();
        return view('positions.create', compact('buses'));
    }

    /**
     * â ï¸ Création MANUELLE (WEB uniquement)
     * Flutter n’utilise PLUS cette méthode
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id'    => 'required|exists:buses,id',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $position = Position::create($validated);

        return response()->json([
            'message'  => 'Position enregistrée â',
            'position' => $position
        ], 201);
    }

    /**
     * â Détail d’une position
     */
    public function show($id)
    {
        return response()->json(
            Position::with('bus')->findOrFail($id)
        );
    }

    /**
     * â Suppression
     */
    public function destroy($id)
    {
        Position::destroy($id);

        return response()->json([
            'message' => 'Position supprimée â'
        ]);
    }

    /**
     * â Filtrage par ville et ligne
     */
    public function getByVilleLigne(Request $request)
    {
        $query = Position::with('bus');

        if ($request->filled('ville_id')) {
            $query->whereHas('bus.ligne', function ($q) use ($request) {
                $q->where('ville_id', $request->ville_id);
            });
        }

        if ($request->filled('ligne_id')) {
            $query->whereHas('bus', function ($q) use ($request) {
                $q->where('ligne_id', $request->ligne_id);
            });
        }

        return response()->json(
            $query->latest()->get()
        );
    }

    /**
     * ð MÉTHODE UTILISÉE PAR FLUTTER
     * Mise à jour ou création automatique de la position du bus
     */
    public function updatePosition(Request $request, $bus_id)
    {
        $validated = $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // ð Vérifie que le bus existe
        $bus = Bus::findOrFail($bus_id);

        // ð Upsert : 1 bus = 1 position
        $position = Position::updateOrCreate(
            ['bus_id' => $bus->id],
            [
                'latitude'  => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]
        );

        return response()->json([
            'message'  => 'Position du bus mise à jour â',
            'position' => $position
        ]);
    }
}
