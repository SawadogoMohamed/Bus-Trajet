<?php

namespace App\Http\Controllers;


use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:departement-liste|departement-ajouter|departement-modifier|departement-supprimer', ['only' => ['index','show']]);
         $this->middleware('permission:departement-ajouter', ['only' => ['create','store']]);
         $this->middleware('permission:departement-modifier', ['only' => ['edit','update']]);
         $this->middleware('permission:departement-supprimer', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departements = Departement::latest()->paginate(40);
        return view('departements.index',compact('departements'))
            ->with('i', (request()->input('page', 1) - 1) * 40);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
{
    $request->validate([
        'nom' => 'unique:departements,nom',
        'description',
        'enregistrer',

        // Ajoutez la validation pour le fichier PDF ici
        'pdf_file' => 'nullable|mimes:pdf|max:2048', // Assure que le fichier est un PDF et a une taille maximale de 2 Mo
    ], [
        'nom.unique' => 'Ce département a déjà été enregistré.',
    ]);

    $departement = new Departement();
    $departement->nom = $request->nom;
    $departement->description = $request->description;
    $departement->enregistrer = $request->enregistrer;

    // Gérer le fichier PDF s'il est présent dans la requête
    if ($request->hasFile('pdf_file')) {
        $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
        $departement->pdf_path = $pdfPath;
    }

    $departement->save();

    return redirect()->route('departements.create')->with('success', 'Département ajouté.');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Departements  $departement
     * @return \Illuminate\Http\Response
     */
    public function show(Departement $departement)
    {
        return view('departements.show',compact('departement'));
    }


    // --------------- debut afficher la page Modifier ------------------------

    public function edit(Departement $departement)
    {
        //dd($projet);
        return view('departements.edit',compact('departement'));
    }

    // --------------- fin afficher la page   Modifier ------------------------

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departement  $Departement
     * @return \Illuminate\Http\Response
     */

    // --------------- debut du traitement de la  Modifier ------------------------



    public function update(Request $request, Departement $departement)
{
    // Validation des champs
    $request->validate([
        'nom' => 'required',
        'description',
        'nouveau_pdf' => 'nullable|mimes:pdf|max:2048', // Ajoutez la validation pour le nouveau fichier PDF
        'modifier',
    ]);

    // Mise à jour des champs non liés au fichier PDF
    $departement->update([
        'nom' => $request->nom,
        'description' => $request->description,
        'modifier' => $request->modifier,
    ]);

    // Traitement du nouveau fichier PDF
    if ($request->hasFile('nouveau_pdf')) {
        // Supprimer l'ancien fichier PDF s'il existe
        Storage::delete($departement->pdf_path);

        // Enregistrer le nouveau fichier PDF
        $pdfPath = $request->file('nouveau_pdf')->store('pdfs', 'public');
        $departement->update(['pdf_path' => $pdfPath]);
    }

    return redirect()->route('departements.index')->with('success', 'Département modifié avec succès');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departement  $departement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departement $departement)
    {
        $departement->delete();

        return redirect()->route('departements.index')
                        ->with('success','departement supprimer');
    }
}
