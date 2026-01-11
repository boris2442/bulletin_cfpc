<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ModuleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // ... (code précédent)
 public function rules(): array
{
    // Récupère l'ID du module de manière sécurisée
    $module = $this->route('module');
    $moduleId = is_object($module) ? $module->id : $module;

    return [
        'specialite_id' => ['required', 'exists:specialites,id'],
'semestre' => 'required|in:S1,S2', // <--- AJOUTE CECI
        'code_module' => [
            'nullable', // On le met nullable car il est en readonly dans la vue
            'string',
            'max:10',
            Rule::unique('modules', 'code_module')->ignore($moduleId),
        ],

        'nom_module' => ['required', 'string', 'max:255'],
        'coef_module' => ['required', 'integer', 'min:1', 'max:100'],

        'ordre' => [
            'required',
            'integer',
            'min:1',
            Rule::unique('modules')
                ->ignore($moduleId)
                ->where(fn($query) => $query->where('specialite_id', $this->specialite_id)),
        ],

        'enseignants' => ['nullable', 'array'],
        'enseignants.*' => ['exists:users,id'],
    ];
}

  /**
 * Messages d'erreur personnalisés.
 */
public function messages(): array
{
    return [
        'ordre.unique' => 'Ce numéro d’ordre est déjà utilisé pour un autre module dans cette spécialité.',
        'semestre.required' => 'Vous devez sélectionner un semestre (S1 ou S2).',
        'semestre.in' => 'Le semestre sélectionné n’est pas valide.',
        'nom_module.required' => 'Le nom du module est obligatoire.',
        'coef_module.min' => 'Le coefficient doit être au moins de 1.',
    ];
}
}
