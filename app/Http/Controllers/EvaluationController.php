<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use App\Models\Evaluation;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $anneeActive = AnneeAcademique::where('statut', true)->first();
        $specialites = Specialite::all();

        $specialite_id = $request->specialite_id;
        $module_id = $request->module_id;
        $semestre = $request->semestre;

        $modules = [];
        $etudiants = [];

        // ÉTAPE 1 : Si la spécialité ET le semestre sont choisis
        // On charge les modules filtrés par ces deux critères
        if ($specialite_id && $semestre) {
            $spe = Specialite::find($specialite_id);

            if ($spe) {
                $formatSemestre = (str_contains($semestre, 'S')) ? $semestre : 'S' . $semestre;

                // On récupère uniquement les modules de CE semestre dans CETTE spécialité
                $modules = $spe->modules()
                    ->wherePivot('semestre', $formatSemestre)
                    ->get();
            }
        }

        // ÉTAPE 2 : On ne récupère les étudiants QUE si les 3 filtres sont là
        // ÉTAPE 2 : On ne récupère les étudiants QUE si les 3 filtres sont là
        if ($specialite_id && $module_id && $semestre) {

            // TRÈS IMPORTANT : On extrait le chiffre (1 ou 2) pour correspondre à la base
            $semestreChiffre = filter_var($semestre, FILTER_SANITIZE_NUMBER_INT);

            $etudiants = User::whereHas('inscriptions', function ($q) use ($specialite_id, $anneeActive) {
                $q->where('specialite_id', $specialite_id)
                    ->where('annee_academique_id', $anneeActive->id);
            })->with(['evaluations' => function ($q) use ($module_id, $semestreChiffre, $anneeActive) {
                $q->where('module_id', $module_id)
                    ->where('semestre', $semestreChiffre) // On cherche le chiffre (ex: 1)
                    ->where('annee_academique_id', $anneeActive->id);
            }])->get();
        }
        return view('pages.evaluations.index', compact('specialites', 'modules', 'etudiants', 'anneeActive'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'required|array',
            'notes.*' => 'nullable|numeric|min:0|max:20',
            'module_id' => 'required',
            'semestre' => 'required',
            'annee_academique_id' => 'required'
        ]);

        // On utilise DB::transaction pour s'assurer que soit tout est enregistré, soit rien (sécurité admin)
        DB::transaction(function () use ($request) {
            foreach ($request->notes as $etudiant_id => $note) {
                if ($note !== null) {
                    // On extrait le chiffre : "S1" devient 1
                    $semestreInt = filter_var($request->semestre, FILTER_SANITIZE_NUMBER_INT);

                    \DB::table('evaluations')->updateOrInsert(
                        [
                            'user_id' => $etudiant_id,
                            'module_id' => $request->module_id,
                            'annee_academique_id' => $request->annee_academique_id,
                            'semestre' => $semestreInt, // Envoie 1 au lieu de "S1"
                        ],
                        ['note' => $note, 'updated_at' => now()]
                    );
                }
            }
        });

        return redirect()->back()->with('success', 'Notes enregistrées avec succès par l\'administration.');
    }
}
