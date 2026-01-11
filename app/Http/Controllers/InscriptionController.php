<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Specialite;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use App\Http\Controllers\Controller;

class InscriptionController extends Controller
{


    // public function index()
    // {
    //     $anneeActive = AnneeAcademique::where('statut', true)->first();
    //     if (!$anneeActive) return redirect()->back()->with('error', 'Activez une année.');

    //     $etudiantsDisponibles = User::where('role', 'Etudiant')
    //         ->whereDoesntHave('inscriptions', function ($q) use ($anneeActive) {
    //             $q->where('annee_academique_id', $anneeActive->id);
    //         })->get();

    //     // On ne récupère que les spécialités
    //     $specialites = Specialite::orderBy('nom_specialite')->get();

    //     $inscriptionsActuelles = Inscription::with(['etudiant', 'specialite'])
    //         ->where('annee_academique_id', $anneeActive->id)
    //         ->latest()->get();

    //     return view('pages.inscriptions.index', compact(
    //         'etudiantsDisponibles',
    //         'inscriptionsActuelles',
    //         'specialites',
    //         'anneeActive'
    //     ));
    // }


public function index()
{
    // 1. On cherche l'année active
    $anneeActive = AnneeAcademique::where('statut', true)->first();

    // SÉCURITÉ : Si $anneeActive est null, on ne continue pas !
    if (!$anneeActive) {
        return redirect()->route('annee-academiques.index')
            ->with('error', 'Aucune année académique n\'est active. Veuillez en activer une avant de gérer les inscriptions.');
    }

    // 2. Maintenant on peut utiliser $anneeActive->id sans risque de crash
    $etudiantsDisponibles = User::where('role', 'Etudiant')
        ->whereDoesntHave('inscriptions', function ($q) use ($anneeActive) {
            $q->where('annee_academique_id', $anneeActive->id);
        })->get();

    $specialites = Specialite::orderBy('nom_specialite')->get();

    $inscriptionsActuelles = Inscription::with(['etudiant', 'specialite'])
        ->where('annee_academique_id', $anneeActive->id)
        ->latest()->get();

    return view('pages.inscriptions.index', compact(
        'etudiantsDisponibles',
        'inscriptionsActuelles',
        'specialites',
        'anneeActive'
    ));
}




    public function store(Request $request)
    {
        $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'annee_academique_id' => 'required|exists:annee_academiques,id',
            'etudiant_ids' => 'required|array|min:1',
        ]);

        foreach ($request->etudiant_ids as $id) {
            Inscription::create([
                'user_id' => $id,
                'specialite_id' => $request->specialite_id,
                'annee_academique_id' => $request->annee_academique_id,
                // On laisse classe_id à null ou on supprime la colonne plus tard
            ]);
        }

    // Au lieu de redirect()->back(), utilise la route précise
return redirect()->route('inscriptions.index')->with('success', 'Inscriptions terminées.');
    }
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->back()->with('success', 'Inscription annulée.');
    }
    public function create()
    {
        $anneeActive = AnneeAcademique::active();

        if (!$anneeActive) {
            return redirect()->back()->with('error', 'Veuillez d\'abord activer une année académique.');
        }

        // On ne récupère que les utilisateurs qui ne sont pas encore inscrits pour cette année
        $etudiants = User::where('role', 'Etudiant')
            ->whereDoesntHave('inscriptions', function ($query) use ($anneeActive) {
                $query->where('annee_academique_id', $anneeActive->id);
            })
            ->get();

        $specialites = Specialite::all();

        return view('pages.inscriptions.create', compact('etudiants', 'specialites', 'anneeActive'));
    }
}
