<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Ligne;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function __construct()
    {
        // ð Permissions UNIQUEMENT pour le WEB
        if (!request()->is('api/*')) {
            $this->middleware(
                'permission:bus-liste|bus-ajouter|bus-modifier|bus-supprimer',
                ['only' => ['index', 'show']]
            );
            $this->middleware('permission:bus-ajouter', ['only' => ['store']]);
            $this->middleware('permission:bus-modifier', ['only' => ['update']]);
            $this->middleware('permission:bus-supprimer', ['only' => ['destroy']]);
        }
    }

    /**
     * ð Liste des bus
     * - WEB : tous les bus
     * - FLUTTER : seulement les bus disponibles
     */
    public function index(Request $request)
    {
        // ð± App Flutter → bus disponibles uniquement
        if ($request->expectsJson() || $request->is('api/*')) {
            $buses = Bus::where('etat', 'actif')
                ->where('occupe', false)
                ->get();

            return response()->json($buses);
        }

        // ð WEB → tous les bus
        $buses = Bus::with('ligne')->get();
        $lignes = Ligne::all();

        return view('buses.index', compact('buses', 'lignes'));
    }

    /**
     * â Formulaire de création (WEB)
     */
    public function create()
    {
        $lignes = Ligne::all();
        return view('buses.create', compact('lignes'));
    }

    /**
     * ð¾ Enregistrer un bus
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ligne_id'   => 'required|exists:lignes,id',
            'numero_bus' => 'required|string|max:50|unique:buses,numero_bus',
            'etat'       => 'nullable|in:actif,hors_service',
        ]);

        $bus = Bus::create(array_merge($validated, [
            'occupe' => false, // ð¢ bus libre par défaut
        ]));

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Bus ajouté avec succès â',
                'bus'     => $bus
            ], 201);
        }

        return redirect()->route('buses.index')->with('success', 'Bus ajouté avec succès');
    }

    /**
     * ð Détails d’un bus
     */
    public function show(Request $request, $id)
    {
        $bus = Bus::with(['ligne', 'positions'])->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($bus);
        }

        return view('buses.show', compact('bus'));
    }

    /**
     * âï¸ Mise à jour d’un bus
     */
    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);
        $bus->update($request->all());

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Bus mis à jour â',
                'bus'     => $bus
            ]);
        }

        return redirect()->route('buses.index')->with('success', 'Bus mis à jour');
    }

    /**
     * â Supprimer un bus
     */
    public function destroy(Request $request, $id)
    {
        Bus::destroy($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Bus supprimé â']);
        }

        return redirect()->route('buses.index')->with('success', 'Bus supprimé');
    }

    /* ======================================================
       ð MÉTHODES UTILISÉES PAR FLUTTER
       ====================================================== */

    /**
     * ð Réserver un bus (quand un chauffeur le choisit)
     */
    public function reserver($bus_id)
    {
        $bus = Bus::findOrFail($bus_id);

        if ($bus->etat !== 'actif') {
            return response()->json([
                'message' => 'Bus hors service'
            ], 403);
        }

        if ($bus->occupe) {
            return response()->json([
                'message' => 'Bus déjà occupé'
            ], 409);
        }

        $bus->update(['occupe' => true]);

        return response()->json([
            'message' => 'Bus réservé avec succès â'
        ]);
    }

    /**
     * ð Libérer un bus (changer de bus)
     */
    public function liberer($bus_id)
    {
        $bus = Bus::findOrFail($bus_id);

        $bus->update(['occupe' => false]);

        return response()->json([
            'message' => 'Bus libéré avec succès â'
        ]);
    }
}
