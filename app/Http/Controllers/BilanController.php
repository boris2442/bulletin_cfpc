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
use App\Models\BilanCompetence;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class BilanController extends Controller
{



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
        $anneeActive = AnneeAcademique::where('statut', true)->first();

        // Récupérer les étudiants
        $etudiants = User::whereHas('inscriptions', function ($q) use ($specialite_id, $anneeActive) {
            $q->where('specialite_id', $specialite_id)
                ->where('annee_academique_id', $anneeActive->id);
        })->get();

        foreach ($etudiants as $etudiant) {
            // 1. Calculs (en utilisant tes méthodes existantes dans le modèle User)
            $moyS1 = $etudiant->moyenneSemestre(1, $anneeActive->id);
            $moyS2 = $etudiant->moyenneSemestre(2, $anneeActive->id);

            $moyenneEvaluations = ($moyS1 + $moyS2) / 2; // Moyenne CC (30%)
            $noteBilan = $etudiant->evaluations()
                ->where('annee_academique_id', $anneeActive->id)
                ->whereHas('module', fn($q) => $q->where('is_bilan', true))
                ->first()?->note ?? 0;

            $moyenneFinale = ($moyenneEvaluations * 0.3) + ($noteBilan * 0.7);

            // 2. ENREGISTREMENT DANS LA TABLE bilan_competences
            BilanCompetence::updateOrCreate(
                [
                    'user_id' => $etudiant->id,
                    'annee_academique_id' => $anneeActive->id,
                ],
                [
                    'moyenne_semestre1'   => $moyS1,
                    'moyenne_semestre2'   => $moyS2,
                    'moyenne_competences' => $moyenneEvaluations,
                    'moyenne_generale'    => $moyenneFinale,
                    'observations'        => $moyenneFinale >= 10 ? 'Admis' : 'Échec',
                ]
            );
        }

        return back()->with('success', 'La table Bilan des Compétences a été mise à jour !');
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




    public function generateSynthesePDF(Request $request)
    {
        $specialite_id = $request->specialite_id;

        if (!$specialite_id) {
            return back()->with('error', 'Veuillez sélectionner une formation.');
        }

        // On utilise ta fonction qui travaille déjà sur la spécialité
        $data = $this->prepareBilanData($specialite_id);

        // On harmonise le nom de la variable stat pour la vue
        $data['stats']['moyenne_classe'] = $data['stats']['moyenne_formation'];
        // Ce code va afficher la liste des modules et arrêter l'exécution

        $pdf = Pdf::loadView('pages.bilans.synthese_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Synthese_' . $data['specialite']->nom_specialite . '.pdf');
    }



    public function generateSyntheseGlobalePDF()
    {
        $anneeActive = AnneeAcademique::where('statut', true)->first();
        $specialites = Specialite::all();

        $bilanGlobal = [];
        $tousLesEtudiants = collect();

        foreach ($specialites as $spec) {
            $data = $this->prepareBilanData($spec->id);

            foreach ($data['etudiants'] as $etudiant) {
                $moy = $etudiant->moyenne_generale;
                // TA LOGIQUE DE MENTIONS
                if ($moy >= 20) $m = 'Parfait';
                elseif ($moy >= 18) $m = 'Excellent';
                elseif ($moy >= 16) $m = 'Très Bien';
                elseif ($moy >= 14) $m = 'Bien';
                elseif ($moy >= 12) $m = 'Assez Bien';
                elseif ($moy >= 10) $m = 'Passable';
                else $m = 'Faible';

                $etudiant->mention_calculee = $m;
            }

            $majorSpec = $data['etudiants']->sortByDesc('moyenne_generale')->first();

            $bilanGlobal[] = [
                'nom' => $spec->nom_specialite,
                'effectif' => $data['stats']['total'],
                'admis' => $data['stats']['admis'],
                'echoues' => $data['stats']['echoues'],
                'moyenne_formation' => $data['stats']['moyenne_formation'],
                'taux' => $data['stats']['total'] > 0 ? ($data['stats']['admis'] / $data['stats']['total']) * 100 : 0,
                'major' => $majorSpec,
            ];

            $tousLesEtudiants = $tousLesEtudiants->concat($data['etudiants']);
        }

        // Calcul des compteurs globaux selon tes mentions
        $statsGlobales = [
            'total' => $tousLesEtudiants->count(),
            'admis' => $tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 10)->count(),
            'taux' => $tousLesEtudiants->count() > 0 ? ($tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 10)->count() / $tousLesEtudiants->count()) * 100 : 0,
            'moyenne_promotion' => $tousLesEtudiants->avg('moyenne_generale'),
            'major_absolu' => $tousLesEtudiants->sortByDesc('moyenne_generale')->first(),
            // Compteurs précis
            'count_excellent' => $tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 18)->count(),
            'count_tres_bien' => $tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 16 && $e->moyenne_generale < 18)->count(),
            'count_bien' => $tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 14 && $e->moyenne_generale < 16)->count(),
            'count_assez_bien' => $tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 12 && $e->moyenne_generale < 14)->count(),
            'count_passable' => $tousLesEtudiants->filter(fn($e) => $e->moyenne_generale >= 10 && $e->moyenne_generale < 12)->count(),
        ];

        $pdf = Pdf::loadView('pages.bilans.synthese_globale_pdf', [
            'bilanGlobal' => $bilanGlobal,
            'anneeActive' => $anneeActive,
            'stats' => $statsGlobales,
            'date' => date('d/m/Y')
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Synthese_Globale.pdf');
    }

    //generation sythese globale
    public function generateSyntheseToutesSpecialitesPDF()
    {
        $anneeActive = AnneeAcademique::where('statut', true)->first();
        $specialites = Specialite::all();

        $toutLeBilan = [];

        foreach ($specialites as $spec) {
            // On récupère les données pour chaque spécialité via ta fonction existante
            $data = $this->prepareBilanData($spec->id);

            // On harmonise la variable stat comme tu l'as fait précédemment
            $data['stats']['moyenne_classe'] = $data['stats']['moyenne_formation'];

            // On stocke les données de cette spécialité dans un tableau global
            $toutLeBilan[] = $data;
        }

        $pdf = Pdf::loadView('pages.bilans.synthese_generale_toutes_formations', [
            'toutLeBilan' => $toutLeBilan,
            'anneeActive' => $anneeActive
        ])->setPaper('a4', 'landscape'); // Paysage est mieux pour les tableaux

        return $pdf->download('Synthese_Generale_Toutes_Formations.pdf');
    }
}
