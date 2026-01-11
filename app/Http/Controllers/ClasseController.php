<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;

class ClasseController extends Controller
{
    public function index()
    {
        // 1. On récupère l'année active pour l'affichage informatif
        $anneeActive = AnneeAcademique::where('statut', true)->first();

        // 2. On récupère les classes avec leurs spécialités
        // On peut aussi compter le nombre d'inscrits pour l'année en cours
        $classes = Classe::with(['specialite', 'inscriptions' => function ($query) use ($anneeActive) {
            $query->where('annee_academique_id', $anneeActive->id);
        }])->get();

        $specialites = Specialite::all();

        return view('pages.classes.index', compact('classes', 'specialites', 'anneeActive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_classe' => 'required|string|max:255',
            'specialite_id' => 'required|exists:specialites,id',
        ]);

        Classe::create($request->all());

        return redirect()->back()->with('success', 'Classe structurelle ajoutée avec succès !');
    }
    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->back()->with('success', 'Classe supprimée !');
    }

    // app/Http/Controllers/ClasseController.php

    public function multiDelete(Request $request)
    {
        // On vérifie ce qui arrive
        $ids = $request->input('ids');

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Aucune classe sélectionnée.');
        }

        \App\Models\Classe::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Sélection supprimée avec succès.');
    }
    /**
     * Optionnel : Ajoutez une méthode show vide ou retirez la de la ressource 
     * pour éviter l'erreur si vous cliquez par mégarde sur un lien direct
     */
    public function show()
    {
        return redirect()->route('classes.index');
    }
}
