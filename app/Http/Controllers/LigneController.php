<?php

namespace App\Http\Controllers;

use App\Models\Ligne;
use App\Models\Ville;
use Illuminate\Http\Request;

class LigneController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ligne-liste|ligne-ajouter|ligne-modifier|ligne-supprimer', ['only' => ['index', 'show']]);
        $this->middleware('permission:ligne-ajouter', ['only' => ['store']]);
        $this->middleware('permission:ligne-modifier', ['only' => ['update']]);
        $this->middleware('permission:ligne-supprimer', ['only' => ['destroy']]);
    }

    public function index()
    {
        $lignes = Ligne::with('ville')->get();
         $villes = Ville::all();
        return view('lignes.index', compact('lignes','villes'));
    }

    public function create()
    {
        $villes = Ville::all();
        return view('lignes.create', compact('villes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ville_id' => 'required|exists:villes,id',
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:lignes,code',
            'description' => 'nullable|string',
        ]);

        Ligne::create($request->all());
        return redirect()->route('lignes.index')->with('success', 'Ligne ajoutée avec succès.');
    }

    public function edit(Ligne $ligne)
    {
        $villes = Ville::all();
        return view('lignes.edit', compact('ligne', 'villes'));
    }

    public function update(Request $request, Ligne $ligne)
    {
        $request->validate([
            'ville_id' => 'required|exists:villes,id',
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:lignes,code,' . $ligne->id,
            'description' => 'nullable|string',
        ]);

        $ligne->update($request->all());
        return redirect()->route('lignes.index')->with('success', 'Ligne mise à jour avec succès.');
    }

    public function destroy(Ligne $ligne)
    {
        $ligne->delete();
        return redirect()->route('lignes.index')->with('success', 'Ligne supprimée.');
    }

    public function getByVille(Request $request)
    {
        $lignes = \App\Models\Ligne::where('ville_id', $request->ville_id)->get();
        return response()->json($lignes);
    }
}
