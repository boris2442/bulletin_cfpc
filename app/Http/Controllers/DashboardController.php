<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use App\Models\Evaluation;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $listeAnnees = AnneeAcademique::orderBy('date_debut', 'desc')->get();
        // 1. Déterminer l'année à analyser
        $anneeActive = $this->getAnneeAnalyse($request);

        if (!$anneeActive) {
            return view('tableau-de-bord')->with('error', 'Aucune année académique trouvée.');
        }

        // 2. Appeler les fonctions spécifiques pour chaque bloc de données
        $statsGlobales = $this->getStatsGlobales($anneeActive->id);
        $performance   = $this->getPerformanceAcademique($anneeActive->id);
        $demographie   = $this->getDemographie($anneeActive->id);
        $repartition   = $this->getRepartitionParSpecialite($anneeActive->id);
        // Nouveautés pédagogiques
        $topFiliere    = $this->getComparatifFilieres($anneeActive->id);
        $etatSaisie     = $this->getEtatSaisieNotes();
        return view('tableau-de-bord', compact(
            'anneeActive',
            'statsGlobales',
            'performance',
            'demographie',
            'repartition',
            'topFiliere',
            'etatSaisie',
            'listeAnnees'
        ));
    }

    // --- FONCTIONS DE CALCUL ---

    private function getAnneeAnalyse($request)
    {
        return $request->annee_id
            ? AnneeAcademique::find($request->annee_id)
            : AnneeAcademique::where('statut', true)->first();
    }

    private function getStatsGlobales($anneeId)
    {
        return [
            'total_etudiants' => Inscription::where('annee_academique_id', $anneeId)->count(),
            'total_enseignants' => User::where('role', 'Enseignant')->count(),
            'total_modules' => Module::count(),
        ];
    }

   

private function getPerformanceAcademique($anneeId)
{
    $inscriptions = Inscription::where('annee_academique_id', $anneeId)
        ->with(['etudiant.evaluations.module', 'specialite'])
        ->get();

    $data = [
        'global' => [],
        'par_specialite' => [],

        'stats' => ['admis' => 0, 'total_notes' => 0]
    ];

    foreach ($inscriptions as $ins) {
        $moyenne = $ins->etudiant->calculerNoteFinale($anneeId);
        $data['stats']['total_notes'] += $moyenne;
        if ($moyenne >= 12) $data['stats']['admis']++;

        $studentData = [
            'nom' => $ins->etudiant->name,
            'moyenne' => round($moyenne, 2),
            'specialite' => $ins->specialite->nom_specialite,
    
        ];

        // Remplir les différents tableaux
        $data['global'][] = $studentData;
        $data['par_specialite'][$ins->specialite->nom_specialite][] = $studentData;

    }

    // Tri des données pour extraire les majors
    $sortFn = fn($a, $b) => $b['moyenne'] <=> $a['moyenne'];
    
    usort($data['global'], $sortFn);
    
    // On ne garde que le top 1 de chaque spécialité/classe
    foreach ($data['par_specialite'] as $key => $students) {
        usort($data['par_specialite'][$key], $sortFn);
        $data['par_specialite'][$key] = $data['par_specialite'][$key][0]; // Le major de la spé
    }

   
    return [
        'taux_reussite' => $inscriptions->count() > 0 ? round(($data['stats']['admis'] / $inscriptions->count()) * 100, 2) : 0,
        'moyenne_generale' => $inscriptions->count() > 0 ? round($data['stats']['total_notes'] / $inscriptions->count(), 2) : 0,
        'top_global' => array_slice($data['global'], 0, 5),
        'majors_specialites' => $data['par_specialite'],
     
    ];
}










    private function getDemographie($anneeId)
    {
        return Inscription::where('annee_academique_id', $anneeId)
            ->join('users', 'inscriptions.user_id', '=', 'users.id')
            ->selectRaw('users.sexe, count(*) as total')
            ->groupBy('users.sexe')
            ->get();
    }

    private function getRepartitionParSpecialite($anneeId)
    {
        return Inscription::where('annee_academique_id', $anneeId)
            ->join('specialites', 'inscriptions.specialite_id', '=', 'specialites.id')
            ->selectRaw('specialites.nom_specialite as label, count(*) as total')
            ->groupBy('specialites.nom_specialite')
            ->get();
    }

    private function getComparatifFilieres($anneeId)
    {
     
        $specialites = Inscription::where('annee_academique_id', $anneeId)
            // Ajoute .evaluations.module ici pour la performance
            ->with(['specialite', 'etudiant.evaluations.module'])
            ->get()
            ->groupBy('specialite.nom_specialite');


        $performanceFiliere = [];

        foreach ($specialites as $nom => $inscrits) {
            // $moyenneFiliere = $inscrits->avg(fn($ins) => $ins->etudiant->calculerNoteFinale($anneeId));


            $moyenneFiliere = $inscrits->avg(fn($ins) => $ins->etudiant->calculerNoteFinale($anneeId)) ?? 0;
            $performanceFiliere[] = [
                'label' => $nom,
                'moyenne' => round($moyenneFiliere, 2)
            ];
        }

        return collect($performanceFiliere)->sortByDesc('moyenne')->take(3);
    }

    private function getEtatSaisieNotes()
    {
        $totalModules = Module::count();
        $modulesAvecNotes = Evaluation::distinct('module_id')->count();

        return [
            'termine' => $modulesAvecNotes,
            'en_attente' => $totalModules - $modulesAvecNotes,
            'pourcentage' => $totalModules > 0 ? round(($modulesAvecNotes / $totalModules) * 100) : 0
        ];
    }
}
