<?php

namespace App\Http\Controllers;

use App\Models\Arret;
use App\Models\Ligne;
use Illuminate\Http\Request;

class ArretController extends Controller
{
    public function __construct()
    {
        // 🔐 Permissions UNIQUEMENT pour le WEB
        if (!request()->is('api/*')) {
            $this->middleware(
                'permission:arret-liste|arret-ajouter|arret-modifier|arret-supprimer',
                ['only' => ['index', 'show']]
            );
            $this->middleware('permission:arret-ajouter', ['only' => ['store']]);
            $this->middleware('permission:arret-modifier', ['only' => ['update']]);
            $this->middleware('permission:arret-supprimer', ['only' => ['destroy']]);
        }
    }

    /**
     * 📄 Liste des arrêts (WEB ou API)
     */
    public function index(Request $request)
    {
        $arrets = Arret::with('ligne')->orderBy('ordre')->get();

        // 📱 API (Flutter)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($arrets);
        }

        // 🌐 WEB
        $lignes = Ligne::all();
        return view('arrets.index', compact('arrets', 'lignes'));
    }

    /**
     * 📝 Formulaire création (WEB)
     */
    public function create()
    {
        $lignes = Ligne::all();
        return view('arrets.create', compact('lignes'));
    }

    /**
     * 💾 Enregistrer un arrêt
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ligne_id'  => 'required|exists:lignes,id',
            'nom'       => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'ordre'     => 'nullable|integer',
        ]);

        $arret = Arret::create($validated);

        // 📱 API
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Arrêt ajouté avec succès',
                'arret'   => $arret
            ], 201);
        }

        // 🌐 WEB
        return redirect()->route('arrets.index')
            ->with('success', 'Arrêt ajouté avec succès');
    }

    /**
     * 🔍 Détails d’un arrêt
     */
    public function show(Request $request, $id)
    {
        $arret = Arret::with('ligne')->findOrFail($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($arret);
        }

        return view('arrets.show', compact('arret'));
    }

    /**
     * ✏️ Mise à jour
     */
    public function update(Request $request, $id)
    {
        $arret = Arret::findOrFail($id);

        $validated = $request->validate([
            'ligne_id'  => 'required|exists:lignes,id',
            'nom'       => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'ordre'     => 'nullable|integer',
        ]);

        $arret->update($validated);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Arrêt mis à jour',
                'arret'   => $arret
            ]);
        }

        return redirect()->route('arrets.index')
            ->with('success', 'Arrêt modifié avec succès');
    }

    /**
     * 🗑️ Suppression
     */
    public function destroy(Request $request, $id)
    {
        Arret::destroy($id);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Arrêt supprimé']);
        }

        return redirect()->route('arrets.index')
            ->with('success', 'Arrêt supprimé avec succès');
    }

    /**
     * 📍 API – Arrêts par ligne (Flutter)
     */
    public function getByLigne(Request $request)
    {
        if (!$request->ligne_id) {
            return response()->json([], 400);
        }

        $arrets = Arret::where('ligne_id', $request->ligne_id)
            ->orderBy('ordre')
            ->get();

        return response()->json($arrets);
    }
}
