<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Classe;
use App\Models\Module;
use App\Models\Evaluation;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class BilanController extends Controller
{





    // public function index(Request $request)
    // {
    //     $anneeActive = AnneeAcademique::where('statut', true)->first();
    //     $classes = Classe::with('specialite')->get();
    //     $classe_id = $request->classe_id;

    //     $etudiants = collect();
    //     $modulesNormaux = collect();
    //     $moduleBilan = null;
    //     $stats = [];

    //     if ($classe_id) {
    //         // On appelle la fonction "cerveau" ci-dessous
    //         $data = $this->prepareBilanData($classe_id);

    //         $etudiants = $data['etudiants'];
    //         $modulesNormaux = $data['modulesNormaux'];
    //         $moduleBilan = $data['moduleBilan'];
    //         $stats = $data['stats'];
    //     }

    //     return view('pages.bilans.index', compact('etudiants', 'modulesNormaux', 'moduleBilan', 'classes', 'anneeActive', 'stats'));
    // }

public function index(Request $request)
{
    $anneeActive = AnneeAcademique::where('statut', true)->first();
    // On ne récupère plus les classes, mais directement les spécialités
    $specialites = Specialite::all(); 
    $specialite_id = $request->specialite_id;

    $etudiants = collect();
    $modulesNormaux = collect();
    $moduleBilan = null;
    $stats = [];

    if ($specialite_id) {
        $data = $this->prepareBilanData($specialite_id);

        $etudiants = $data['etudiants'];
        $modulesNormaux = $data['modulesNormaux'];
        $moduleBilan = $data['moduleBilan'];
        $stats = $data['stats'];
    }

    return view('pages.bilans.index', compact('etudiants', 'modulesNormaux', 'moduleBilan', 'specialites', 'anneeActive', 'stats'));
}















    // private function prepareBilanData($classe_id)
    // {
    //     $anneeActive = AnneeAcademique::where('statut', true)->first();
    //     $classe = Classe::with('specialite')->findOrFail($classe_id);

    //     $modulesNormaux = Module::where('specialite_id', $classe->specialite_id)
    //         ->where('is_bilan', false)->get();

    //     $moduleBilan = Module::where('specialite_id', $classe->specialite_id)
    //         ->where('is_bilan', true)->first();

    //     $etudiants = User::whereHas('inscriptions', function ($q) use ($classe_id, $anneeActive) {
    //         $q->where('classe_id', $classe_id)->where('annee_academique_id', $anneeActive->id);
    //     })
    //         ->with(['evaluations' => function ($q) use ($anneeActive) {
    //             $q->where('annee_academique_id', $anneeActive->id);
    //         }])->get();

    //     // Calcul pour chaque étudiant
    //     $etudiants->each(function ($etudiant) use ($modulesNormaux, $anneeActive) {
    //         // On délègue les calculs complexes au modèle User
    //         $etudiant->moyenne_s1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
    //         $etudiant->moyenne_s2 = $etudiant->moyenneSemestre(2, $anneeActive->id);
    //         $etudiant->moyenne_generale = $etudiant->calculerNoteFinale($anneeActive->id);
    //     });

    //     // Statistiques de classe
    //     $moyennes = $etudiants->pluck('moyenne_generale');
    //     $stats = [
    //         'total' => $etudiants->count(),
    //         'admis' => $moyennes->filter(fn($m) => $m >= 10)->count(),
    //         'echoues' => $moyennes->filter(fn($m) => $m < 10)->count(),
    //         'moyenne_classe' => $moyennes->avg() ?? 0,
    //         'meilleure_note' => $moyennes->max() ?? 0,
    //         'moins_bonne' => $moyennes->min() ?? 0,
    //     ];

    //     return compact('etudiants', 'modulesNormaux', 'moduleBilan', 'anneeActive', 'classe', 'stats');
    // }



// private function prepareBilanData($specialite_id)
// {
//     $anneeActive = AnneeAcademique::where('statut', true)->first();
//     $specialite = Specialite::findOrFail($specialite_id);

//     // Les modules de la formation (Spécialité)
//     $modulesNormaux = Module::where('specialite_id', $specialite_id)
//         ->where('is_bilan', false)->get();

//     $moduleBilan = Module::where('specialite_id', $specialite_id)
//         ->where('is_bilan', true)->first();

//     // On récupère les étudiants inscrits directement dans la SPÉCIALITÉ
//     $etudiants = User::whereHas('inscriptions', function ($q) use ($specialite_id, $anneeActive) {
//         $q->where('specialite_id', $specialite_id)
//           ->where('annee_academique_id', $anneeActive->id);
//     })
//     ->with(['evaluations' => function ($q) use ($anneeActive) {
//         $q->where('annee_academique_id', $anneeActive->id);
//     }])->get();

//     // Calculs
//     $etudiants->each(function ($etudiant) use ($anneeActive) {
//         $etudiant->moyenne_s1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
//         $etudiant->moyenne_s2 = $etudiant->moyenneSemestre(2, $anneeActive->id);
//         $etudiant->moyenne_generale = $etudiant->calculerNoteFinale($anneeActive->id);
//     });

//     $moyennes = $etudiants->pluck('moyenne_generale');
//     $stats = [
//         'total' => $etudiants->count(),
//         'admis' => $moyennes->filter(fn($m) => $m >= 10)->count(),
//         'echoues' => $moyennes->filter(fn($m) => $m < 10)->count(),
//         'moyenne_formation' => $moyennes->avg() ?? 0,
//     ];

//     return compact('etudiants', 'modulesNormaux', 'moduleBilan', 'anneeActive', 'specialite', 'stats');
// }






// private function prepareBilanData($specialite_id)
// {
//     $anneeActive = AnneeAcademique::where('statut', true)->first();
//     $specialite = Specialite::findOrFail($specialite_id);

//     // On récupère les modules RATTACHÉS à cette spécialité via le pivot
//     $modulesFormation = $specialite->modules()
//         ->withPivot('semestre', 'ordre') // On demande explicitement le pivot
//         ->orderBy('module_specialite.ordre')
//         ->get();

//     // On filtre : modules normaux vs module bilan
//     $modulesNormaux = $modulesFormation->where('is_bilan', false);
//     $moduleBilan = $modulesFormation->where('is_bilan', true)->first();

//     $etudiants = User::whereHas('inscriptions', function ($q) use ($specialite_id, $anneeActive) {
//         $q->where('specialite_id', $specialite_id)
//           ->where('annee_academique_id', $anneeActive->id);
//     })
//     ->with(['evaluations' => function ($q) use ($anneeActive) {
//         $q->where('annee_academique_id', $anneeActive->id);
//     }])->get();

//     // Calculs
//     $etudiants->each(function ($etudiant) use ($anneeActive) {
//         $etudiant->moyenne_s1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
//         $etudiant->moyenne_s2 = $etudiant->moyenneSemestre(2, $anneeActive->id);
//         $etudiant->moyenne_generale = $etudiant->calculerNoteFinale($anneeActive->id);
//     });

//     // ... reste des stats
//     return compact('etudiants', 'modulesNormaux', 'moduleBilan', 'anneeActive', 'specialite');
// }






private function prepareBilanData($specialite_id)
{
    $anneeActive = AnneeAcademique::where('statut', true)->first();
    $specialite = Specialite::findOrFail($specialite_id);

    // 1. Récupération des modules via la table pivot
    $modulesFormation = $specialite->modules()
        ->withPivot('semestre', 'ordre')
        ->orderBy('module_specialite.ordre')
        ->get();

    $modulesNormaux = $modulesFormation->where('is_bilan', false);
    $moduleBilan = $modulesFormation->where('is_bilan', true)->first();

    // 2. Récupération des étudiants
    $etudiants = User::whereHas('inscriptions', function ($q) use ($specialite_id, $anneeActive) {
        $q->where('specialite_id', $specialite_id)
          ->where('annee_academique_id', $anneeActive->id);
    })
    ->with(['evaluations' => function ($q) use ($anneeActive) {
        $q->where('annee_academique_id', $anneeActive->id);
    }])->get();

    // 3. Calculs des moyennes pour chaque étudiant
    $etudiants->each(function ($etudiant) use ($anneeActive) {
        // Attention : Vérifiez si vos méthodes attendent 'S1' ou 1
        $etudiant->moyenne_s1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
        $etudiant->moyenne_s2 = $etudiant->moyenneSemestre(2, $anneeActive->id);
        $etudiant->moyenne_generale = $etudiant->calculerNoteFinale($anneeActive->id);
    });

    // 4. Calcul des statistiques (CE QUI MANQUAIT)
    $moyennes = $etudiants->pluck('moyenne_generale');
    $stats = [
        'total'    => $etudiants->count(),
        'admis'    => $moyennes->filter(fn($m) => $m >= 10)->count(),
        'echoues'  => $moyennes->filter(fn($m) => $m < 10)->count(),
        'moyenne_formation' => $moyennes->avg() ?? 0,
    ];

    // On ajoute 'stats' dans le compact pour corriger l'erreur 500
    return compact('etudiants', 'modulesNormaux', 'moduleBilan', 'anneeActive', 'specialite', 'stats');
}







    /**
     * Affiche le bilan individuel d'un étudiant (optionnel)
     */
    // public function show($id)
    // {
    //     // On ajoute 'inscriptions.classe' pour l'afficher sur le relevé
    //     $etudiant = User::with([
    //         'evaluations.module',
    //         'inscriptions.specialite',
    //         'inscriptions.classe',
    //         //MAtricule peut être ajouté ici si besoin

    //     ])->findOrFail($id);
    //     $anneeActive = AnneeAcademique::where('statut', true)->first();

    //     // On utilise les méthodes de calcul définies dans le modèle User
    //     $moyenneS1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
    //     $moyenneS2 = $etudiant->moyenneSemestre(2, $anneeActive->id);
    //     $moyenneFinale = $etudiant->calculerNoteFinale($anneeActive->id);

    //     return view('pages.bilans.show', compact('etudiant', 'anneeActive', 'moyenneS1', 'moyenneS2', 'moyenneFinale'));
    // }




public function show($id)
{
    // On retire 'inscriptions.classe' car on travaille désormais par Spécialité/Formation
    $etudiant = User::with([
        'evaluations.module',
        'inscriptions.specialite',
    ])->findOrFail($id);

    $anneeActive = AnneeAcademique::where('statut', true)->first();

    // On s'assure que l'année active existe pour éviter des erreurs de calcul
    if (!$anneeActive) {
        return back()->with('error', 'Aucune année académique active trouvée.');
    }

    // Les méthodes de calcul restent valides tant qu'elles se basent sur l'ID de l'étudiant et l'année
    $moyenneS1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
    $moyenneS2 = $etudiant->moyenneSemestre(2, $anneeActive->id);
    $moyenneFinale = $etudiant->calculerNoteFinale($anneeActive->id);

    return view('pages.bilans.show', compact(
        'etudiant', 
        'anneeActive', 
        'moyenneS1', 
        'moyenneS2', 
        'moyenneFinale'
    ));
}






    public function genererSynthese($specialite_id)
    {
        $anneeActive = AnneeAcademique::active();

        // Récupérer les étudiants de cette spécialité
        $etudiants = User::whereHas('inscriptions', function ($q) use ($specialite_id, $anneeActive) {
            $q->where('specialite_id', $specialite_id)
                ->where('annee_academique_id', $anneeActive->id);
        })->with('evaluations.module')->get();


        foreach ($etudiants as $etudiant) {
            // 1. Calcul Moyenne Semestre 1 (Modules M1-M5)
            $moyenneS1 = $etudiant->calculerMoyennePonderee(1);

            // 2. Calcul Moyenne Semestre 2 (Modules M6-M10)
            $moyenneS2 = $etudiant->calculerMoyennePonderee(2);

            // 3. Moyenne des évaluations (30%)
            $moyenneEvaluations = ($moyenneS1 + $moyenneS2) / 2;

            // 4. Note du Bilan (70%) - Supposons qu'on la récupère
            $noteBilan = $etudiant->evaluations()->where('is_bilan', true)->first()?->note ?? 0;

            // 5. MOYENNE GÉNÉRALE FINALE
            $moyenneFinale = ($moyenneEvaluations * 0.3) + ($noteBilan * 0.7);
        }
    }


    public function store(Request $request)
    {
        $module_id = $request->module_id;
        $annee_id = AnneeAcademique::where('statut', 1)->first()->id;

        foreach ($request->notes as $student_id => $note) {
            if ($note !== null) {
                Evaluation::updateOrCreate(
                    [
                        'user_id' => $student_id,
                        'module_id' => $module_id,
                        'annee_academique_id' => $annee_id,
                    ],
                    // ['note' => $note]
                    [
                    'note' => $note,
                    'semestre' => 0 // <--- On ajoute le 0 pour corriger l'erreur SQL
                ]
                );
            }
        }

        return redirect()->back()->with('success', 'Notes de bilan enregistrées avec succès !');
    }









    // ...

    // public function generatePDF(Request $request)
    // {
    //     $classe_id = $request->classe_id;
    //     if (!$classe_id) return back();

    //     // On utilise la même logique que l'index
    //     $data = $this->prepareBilanData($classe_id);

    //     // On charge la vue spéciale PDF (qu'on va créer après)
    //     $pdf = Pdf::loadView('pages.bilans.pdf', $data)
    //         ->setPaper('a4', 'landscape'); // Important pour la largeur

    //     return $pdf->download('Synthese_Annuelle_' . now()->format('Y') . '.pdf');
    // }

    public function generatePDF($id)
{
    // 1. Récupérer l'étudiant avec ses relations
    $etudiant = User::with([
        'evaluations.module',
        'inscriptions.specialite',
        'inscriptions.anneeAcademique'
    ])->findOrFail($id);

    $anneeActive = AnneeAcademique::where('statut', true)->first();

    // 2. Préparer les données pour la vue
    $data = [
        'etudiant'    => $etudiant,
        'anneeActive' => $anneeActive,
        'date'        => date('d/m/Y'),
    ];

    // 3. Charger la vue PDF (celle que tu as commencé à écrire)
    // Assure-toi que le fichier s'appelle 'pages.bilans.releve_pdf' ou similaire
    $pdf = Pdf::loadView('pages.bilans.releve_pdf', $data);

    // 4. Configuration optionnelle (Portrait, A4)
    $pdf->setPaper('a4', 'portrait');

    // 5. Télécharger ou afficher
    return $pdf->download('Releve_Notes_' . $etudiant->matricule . '.pdf');
}















    public function downloadRelevePdf($id)
    {
        $etudiant = User::with([
            'evaluations.module',
            'inscriptions.specialite',
          
        ])->findOrFail($id);

        $anneeActive = AnneeAcademique::where('statut', true)->first();

        // On prépare les données (calculs identiques à la vue)
        $data = [
            'etudiant'    => $etudiant,
            'anneeActive' => $anneeActive,
            'date'        => date('d/m/Y'),
        ];

        $pdf = Pdf::loadView('pages.bilans.releve_pdf', $data)
            ->setPaper('a4', 'portrait') // Format vertical pour un relevé
            ->setOptions([
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
            ]);

        return $pdf->download('Releve_' . str_replace(' ', '_', $etudiant->name) . '.pdf');
    }






 public function printBatch(Request $request)
{
    $ids = explode(',', $request->query('ids'));

    // On utilise User car c'est ton modèle pour les étudiants
    $etudiants = User::with([
        'evaluations.module', 
        'inscriptions.classe', 
        'inscriptions.specialite'
    ])->whereIn('id', $ids)->get();

    // On utilise 'statut' car c'est ce qui existe dans ta base de données
    $anneeActive = AnneeAcademique::where('statut', 1)->first();
    $date = date('d/m/Y');

    // ATTENTION AU CHEMIN : pages.bilans (avec un S)
    $pdf = Pdf::loadView('pages.bilans.pdf_batch', compact('etudiants', 'anneeActive', 'date'));

    $pdf->setPaper('a4', 'portrait');

    return $pdf->download('releves_groupes.pdf');
}

}
