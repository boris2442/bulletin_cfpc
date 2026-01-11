<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Http\Requests\ModuleStoreRequest;
use App\Http\Requests\ModuleUpdateRequest;

class ModuleController extends Controller
{
    /**
     * Affiche la liste des modules.
     */
    // public function index()
    // {
    //     // Charge les relations nécessaires pour l'affichage (specialite et enseignants)
    //     $modules = Module::with(['specialite', 'enseignants'])
    //         ->orderBy('specialite_id')
    //         ->orderBy('semestre') // Nouveau tri
    //         ->orderBy('ordre')
    //         ->get();

    //     return view('pages.modules.index', compact('modules'));
    // }





public function index()
{
    // On récupère les modules avec leurs spécialités rattachées
    // On trie simplement par nom ou code maintenant que l'ordre est spécifique à chaque spécialité
    $modules = Module::with('specialites')
        ->orderBy('nom_module', 'asc')
        ->get();

 return view('pages.modules.index', compact('modules'));
}




    /**
     * Affiche le formulaire de création d'un nouveau module.
     */
    public function create()
    {
        $specialites = Specialite::orderBy('nom_specialite')->get();
        // Optionnel : Récupérer uniquement les utilisateurs ayant le rôle 'enseignant'
        $enseignants = User::where('role', 'enseignant')->orderBy('name')->get();
        // Crée un nouvel objet Module vide (pour la logique d'édition)
        $module = new Module();
        return view('pages.modules.create', compact('specialites', 'enseignants', 'module'));
    }

    /**
     * Stocke un nouveau module dans la base de données.
     */
    public function store(Request $request)
    {
        // 1. Validation
    // 1. Validation simplifiée
    $validated = $request->validate([
        'nom_module' => 'required|string|max:255',
        'coef_module' => 'required|integer|min:1',
        'specialites' => 'required|array', 
        'semestre' => 'required|string',
        'ordre' => 'required|integer', // On vérifie juste que c'est un nombre
        'enseignants' => 'nullable|array',
        'is_bilan' => 'nullable|boolean',
    ]);

        // 2. Création du module (Données de base)
        $module = Module::create([
            'nom_module' => $validated['nom_module'],
            'coef_module' => $validated['coef_module'],
            'is_bilan' => $request->has('is_bilan'),
        ]);

        // 3. Préparation des données pour la table pivot
        // On veut que chaque spécialité sélectionnée ait le même semestre et ordre
        $pivotData = [];
        foreach ($validated['specialites'] as $specialiteId) {
            $pivotData[$specialiteId] = [
                'semestre' => $validated['semestre'],
                'ordre' => $validated['ordre'],
            ];
        }

        // 4. Attachement aux spécialités (Table pivot module_specialite)
        $module->specialites()->sync($pivotData);

        // 5. Attachement des enseignants (Table pivot module_enseignant)
        if ($request->has('enseignants')) {
            $module->enseignants()->sync($request->enseignants);
        }

        return redirect()->route('modules.index')->with('success', 'Module créé avec succès pour toutes les spécialités sélectionnées.');
    }
    /**
     * Affiche le formulaire de modification d'un module.
     */
    public function edit(Module $module)
    {
        $specialites = Specialite::orderBy('nom_specialite')->get();
        // Optionnel : Récupérer uniquement les utilisateurs ayant le rôle 'enseignant'
        $enseignants = User::where('role', 'enseignant')->orderBy('name')->get();

        // Récupérer les IDs des enseignants déjà assignés pour pré-cocher les cases
        $assignedEnseignantsIds = $module->enseignants->pluck('id')->toArray();

        return view('pages.modules.create', compact('module', 'specialites', 'enseignants', 'assignedEnseignantsIds'));
    }

    /**
     * Met à jour le module spécifié.
     */
  public function update(Request $request, Module $module)
{
    // 1. Validation (On utilise Request $request directement pour simplifier)
    $validated = $request->validate([
        'nom_module' => 'required|string|max:255',
        'coef_module' => 'required|integer|min:1',
        'specialites' => 'required|array', 
        'semestre' => 'required|string',
        'ordre' => 'required|integer',
        'enseignants' => 'nullable|array',
        'is_bilan' => 'nullable',
    ]);

    // 2. Mise à jour du module (uniquement les champs de la table modules)
    $module->update([
        'nom_module' => $validated['nom_module'],
        'coef_module' => $validated['coef_module'],
        'is_bilan' => $request->has('is_bilan'),
    ]);

    // 3. Mise à jour de la table pivot (Spécialités, Semestre, Ordre)
    $pivotData = [];
    foreach ($validated['specialites'] as $specialiteId) {
        $pivotData[$specialiteId] = [
            'semestre' => $validated['semestre'],
            'ordre' => $validated['ordre'],
        ];
    }
    $module->specialites()->sync($pivotData);

    // 4. Mise à jour des enseignants
    $module->enseignants()->sync($request->enseignants ?? []);

    return redirect()->route('modules.index')->with('success', 'Le module ' . $module->nom_module . ' a été mis à jour.');
}

// Optionnel : Ajoute cette méthode pour éviter l'erreur "Call to undefined method show"
public function show(Module $module)
{
    return redirect()->route('modules.edit', $module);
}
    /**
     * Supprime le module spécifié.
     */
    public function destroy(Module $module)
    {
        // Laravel gère l'effacement des liaisons dans la table pivot grâce au `onDelete('cascade')` dans la migration

        try {
            $module->delete();
            return redirect()->route('modules.index')->with('success', 'Le module a été supprimé.');
        } catch (\Exception $e) {
            // Dans le cas où il y aurait d'autres contraintes (non visible ici, comme des notes), on peut avoir un message d'erreur.
            return redirect()->route('modules.index')->with('error', 'Impossible de supprimer ce module car il est utilisé ailleurs.');
        }
    }
}
