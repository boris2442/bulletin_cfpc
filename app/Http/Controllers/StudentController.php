<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classe;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $anneeActive = AnneeAcademique::where('statut', true)->first();

        // Récupérer toutes les évaluations de l'étudiant pour l'année en cours
        $evaluations = $student->evaluations()
            ->where('annee_academique_id', $anneeActive->id)
            ->with('module')
            ->get();

        // Séparer les notes (S1, S2 et Bilan)
        $notesS1 = $evaluations->where('semestre', 1)->where('module.is_bilan', false);
        $notesS2 = $evaluations->where('semestre', 2)->where('module.is_bilan', false);
        $noteBilan = $evaluations->where('module.is_bilan', true)->first();

        // Calcul des moyennes
        $moyS1 = $notesS1->avg('note') ?? 0;
        $moyS2 = $notesS2->avg('note') ?? 0;
        $moyModules = ($moyS1 + $moyS2) / 2;

        $valeurBilan = $noteBilan ? $noteBilan->note : 0;

        // Calcul Final : (Moyenne Modules * 30%) + (Bilan * 70%)
        $moyenneGenerale = ($moyModules * 0.3) + ($valeurBilan * 0.7);

        return view('pages.student.notes', compact(
            'student',
            'notesS1',
            'notesS2',
            'noteBilan',
            'moyS1',
            'moyS2',
            'moyenneGenerale',
            'anneeActive'
        ));
    }




public function indexList(Request $request)
{
    // 1. On récupère l'ID de l'année académique active
    $anneeActive = AnneeAcademique::where('statut', true)->first();

    // 2. Requête de base : On ne prend que ceux qui ont une inscription pour CETTE année
    $query = User::where('role', 'Etudiant')
        ->whereHas('inscriptions', function($q) use ($anneeActive) {
            $q->where('annee_academique_id', $anneeActive->id);
        })
        ->with(['inscriptions' => function($q) use ($anneeActive) {
            // On ne charge que l'inscription de l'année en cours et la spécialité
            $q->where('annee_academique_id', $anneeActive->id)->with(['specialite']);
        }]);

    // 3. Application des filtres
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('matricule', 'like', "%{$request->search}%");
        });
    }

    if ($request->filled('specialite_id')) {
        $query->whereHas('inscriptions', function ($q) use ($request, $anneeActive) {
            $q->where('specialite_id', $request->specialite_id)
              ->where('annee_academique_id', $anneeActive->id);
        });
    }

    // 4. Récupération des données
    $students = $query->latest()->paginate(15)->withQueryString();
    $specialites = Specialite::all();

    return view('pages.student.indexList', compact('students', 'specialites', 'anneeActive'));
}

}
