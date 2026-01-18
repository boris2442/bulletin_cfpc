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
use Illuminate\Support\Facades\File;
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

    public function show(User $student)
    {
        // On charge l'inscription et la spécialité pour éviter les erreurs dans la vue
        $student->load('inscriptions.specialite');

        return view('pages.student.show', compact('student'));
    }



    // Affiche le formulaire avec les données existantes
    public function edit(User $student)
    {
        $specialites = Specialite::all();
        $sexes = User::getSexeEnumValues();

        // On récupère l'ID de la spécialité actuelle via la dernière inscription
        $currentSpecialiteId = $student->inscriptions()->latest()->first()?->specialite_id;

        return view('pages.student.edit', compact('student', 'specialites', 'sexes', 'currentSpecialiteId'));
    }

    public function update(Request $request, User $student)
    {
        // 1. Validation (Email unique sauf pour cet utilisateur)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'sexe' => 'required|in:Masculin,Féminin',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'specialite_id' => 'required|exists:specialites,id',
            'telephone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        return DB::transaction(function () use ($request, $student) {

            // --- LOGIQUE IMAGE ---
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo si elle existe
                if ($student->photo) {
                    $oldPath = public_path('uploads/students/' . $student->photo);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $file = $request->file('photo');
                $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/students'), $photoName);

                // On met à jour le nom dans l'objet
                $student->photo = $photoName;
            }

            // 2. Mise à jour de l'utilisateur
            $student->update([
                'name' => $request->name,
                'email' => $request->email,
                'sexe' => $request->sexe,
                'date_naissance' => $request->date_naissance,
                'lieu_naissance' => $request->lieu_naissance,
                'telephone' => $request->telephone,
                // La photo est déjà mise à jour dans l'objet si changée
                'photo' => $student->photo,
            ]);

            // 3. Mise à jour de la spécialité (sur l'inscription la plus récente)
            $inscription = $student->inscriptions()->latest()->first();
            if ($inscription) {
                $inscription->update([
                    'specialite_id' => $request->specialite_id
                ]);
            }

            return redirect()->route('students.indexList')
                ->with('success', "Le profil de {$student->name} a été mis à jour.");
        });
    }
}
