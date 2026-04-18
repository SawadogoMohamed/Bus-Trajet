<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Conducteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConducteurController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:conducteur-liste|conducteur-ajouter|conducteur-modifier|conducteur-supprimer', ['only' => ['index', 'show']]);
        $this->middleware('permission:conducteur-ajouter', ['only' => ['store']]);
        $this->middleware('permission:conducteur-modifier', ['only' => ['update']]);
        $this->middleware('permission:conducteur-supprimer', ['only' => ['destroy']]);
    }

    public function index()
    {
        return response()->json(Conducteur::with('bus')->get());
    }


     public function create()
    {
        $buses = Bus::all();
        return view('conducteurs.create', compact('buses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'nomPrenom' => 'required|string|max:255',
            'email' => 'required|email|unique:conducteurs',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $conducteur = Conducteur::create($validated);
        return response()->json($conducteur, 201);
    }

    public function show($id)
    {
        $conducteur = Conducteur::with('bus')->findOrFail($id);
        return response()->json($conducteur);
    }

    public function update(Request $request, $id)
    {
        $conducteur = Conducteur::findOrFail($id);
        $conducteur->update($request->except('password'));

        if ($request->filled('password')) {
            $conducteur->update(['password' => Hash::make($request->password)]);
        }

        return response()->json($conducteur);
    }

    public function destroy($id)
    {
        Conducteur::destroy($id);
        return response()->json(['message' => 'Conducteur supprimé']);
    }
}
