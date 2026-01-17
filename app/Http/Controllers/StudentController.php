<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Specialite;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            ->whereHas('inscriptions', function ($q) use ($anneeActive) {
                $q->where('annee_academique_id', $anneeActive->id);
            })
            ->with(['inscriptions' => function ($q) use ($anneeActive) {
                // On ne charge que l'inscription de l'année en cours et la spécialité
                $q->where('annee_academique_id', $anneeActive->id)->with(['specialite']);
            }]);

        // 3. Application des filtres
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
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
    public function create()
    {
        $anneeActive = AnneeAcademique::where('statut', true)->first();
        $specialites = Specialite::all();

        // On récupère dynamiquement les options de la colonne sexe
        $sexes = User::getSexeEnumValues();

        return view('pages.student.create', compact('anneeActive', 'specialites', 'sexes'));
    }

    //store method to save new student
    // public function store(Request $request)
    // {
    //     // 1. Validation (On ne valide pas le matricule ici s'il est auto-généré)
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'sexe' => 'required|in:Masculin,Féminin',
    //         'date_naissance' => 'required|date',
    //         'lieu_naissance' => 'required|string',
    //         'specialite_id' => 'required|exists:specialites,id',
    //         'telephone' => 'nullable|string',
    //     ]);

    //     // 2. Utilisation d'une Transaction DB pour éviter de créer un user sans inscription
    //     return DB::transaction(function () use ($request) {

    //         // 3. Récupération de l'année active (indispensable pour l'inscription)
    //         $anneeActive = AnneeAcademique::where('statut', true)->first();

    //         if (!$anneeActive) {
    //             return back()->with('error', "Aucune année académique active n'a été trouvée.");
    //         }

    //         // 4. Création de l'étudiant
    //         // Le matricule sera généré par ton système existant (Model Boot ou autre)
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make('password123'), // Mot de passe par défaut
    //             'sexe' => $request->sexe,
    //             'role' => 'Etudiant', // On force le rôle
    //             'date_naissance' => $request->date_naissance,
    //             'lieu_naissance' => $request->lieu_naissance,
    //             'telephone' => $request->telephone,
    //         ]);

    //         // 5. Création de l'inscription liée
    //         Inscription::create([
    //             'user_id' => $user->id,
    //             'specialite_id' => $request->specialite_id,
    //             'annee_academique_id' => $anneeActive->id,
    //             'date_inscription' => now(),
    //         ]);

    //         return redirect()->route('students.indexList')
    //             ->with('success', "L'étudiant {$user->name} a été créé avec succès.");
    //     });
    // }



    // store method to save new student
    public function store(Request $request)
    {
        // 1. Validation (Ajout de la validation photo)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'sexe' => 'required|in:Masculin,Féminin',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'specialite_id' => 'required|exists:specialites,id',
            'telephone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validation photo
        ]);

        // 2. Utilisation d'une Transaction DB
        return DB::transaction(function () use ($request) {

            // 3. Récupération de l'année active
            $anneeActive = AnneeAcademique::where('statut', true)->first();

            if (!$anneeActive) {
                return back()->with('error', "Aucune année académique active n'a été trouvée.");
            }

            // --- LOGIQUE IMAGE ---
            $photoName = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                // Nom unique : timestamp + id unique
                $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                // On déplace directement dans public/uploads/students
                $file->move(public_path('uploads/students'), $photoName);
            }
            // ---------------------

            // 4. Création de l'étudiant
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'photo' => $photoName, // On enregistre le nom du fichier ici
                'sexe' => $request->sexe,
                'role' => 'Etudiant',
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'telephone' => $request->telephone,
            ]);

            // 5. Création de l'inscription liée
            Inscription::create([
                'user_id' => $user->id,
                'specialite_id' => $request->specialite_id,
                'annee_academique_id' => $anneeActive->id,
                'date_inscription' => now(),
            ]);

            return redirect()->route('students.indexList')
                ->with('success', "L'étudiant {$user->name} a été créé avec succès.");
        });
    }
}
