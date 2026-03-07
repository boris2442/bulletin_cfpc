<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sexe',
        'role',

        'date_naissance', // Doit être ici
        'lieu_naissance', // Doit être ici
        'telephone',      // Doit être ici
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Un utilisateur (étudiant) peut avoir plusieurs inscriptions 
     * (une par année académique).
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Un étudiant a plusieurs notes (évaluations).
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }



    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (empty($user->matricule) || str_contains($user->matricule, 'TEMP')) {
                // ... ta logique de préfixe ...
                $prefix = match ($user->role) {
                    'Administrateur' => 'A',
                    'Enseignant'     => 'P',
                    'Etudiant'       => 'E',
                    default          => 'U',
                };

                $year = date('Y');
                $lastUser = self::withTrashed()
                    ->where('matricule', 'like', $prefix . $year . '%')
                    ->where('matricule', 'NOT LIKE', 'TEMP%') // On ignore les temporaires
                    ->orderBy('matricule', 'desc')
                    ->first();

                $number = $lastUser ? intval(substr($lastUser->matricule, -4)) + 1 : 1;
                $user->matricule = $prefix . $year . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Les modules enseignés par cet utilisateur (professeur).
     */
    public function modulesEnseignes()
    {
        return $this->belongsToMany(Module::class, 'module_enseignant', 'user_id', 'module_id')
            ->withTimestamps();
    }


    // Remplace 'classeActuelle' par 'specialiteActuelle'
    public function specialiteActuelle()
    {
        // On récupère la dernière inscription pour savoir dans quelle spécialité il est cette année
        return $this->hasOne(Inscription::class)->latestOfMany();
    }


    /**
     * Calcule la moyenne d'un étudiant pour un semestre et une année donnée
     */




    /**
     * Calcule la moyenne d'un étudiant pour un semestre et une année donnée
     */







    public function calculerNoteFinale($annee_id)
    {
        // 1. Moyenne des modules (30%)
        $moyenneS1 = $this->moyenneSemestre(1, $annee_id);
        $moyenneS2 = $this->moyenneSemestre(2, $annee_id);
        $moyenneModules = ($moyenneS1 + $moyenneS2) / 2;

        // 2. Note du Bilan (70%)
        $noteBilan = $this->evaluations()
            ->where('annee_academique_id', $annee_id)
            ->whereHas('module', function ($q) {
                $q->where('is_bilan', true);
            })
            ->first()?->note ?? 0;

        // 3. Total pondéré
        return ($moyenneModules * 0.3) + ($noteBilan * 0.7);
    }








    public function moyenneSemestre($semestreInput, $annee_id)
    {
        // ÉTAPE 1 : Normalisation du semestre
        // Si on reçoit 1 ou 2, on transforme en 'S1' ou 'S2'
        // Si on reçoit déjà 'S1', on le garde.
        $semestreLabel = (is_numeric($semestreInput)) ? 'S' . $semestreInput : $semestreInput;

        // ÉTAPE 2 : Récupération des évaluations
        $evals = $this->evaluations()
            ->where('annee_academique_id', $annee_id)
            ->whereHas('module', function ($q) use ($semestreLabel) {
                $q->where('is_bilan', false);

                // On cherche dans la table pivot module_specialite car c'est là 
                // que le semestre est défini pour une formation précise
                $q->whereHas('specialites', function ($sq) use ($semestreLabel) {
                    $sq->where('module_specialite.semestre', $semestreLabel);
                });
            })->get();

        $somme = 0;
        $totalCoef = 0;

        foreach ($evals as $ev) {
            if ($ev->module) {
                $coef = $ev->module->coef_module ?? 1;
                $somme += ($ev->note * $coef);
                $totalCoef += $coef;
            }
        }

        return $totalCoef > 0 ? $somme / $totalCoef : 0;
    }



    public static function getSexeEnumValues()
    {
        // Correction : On passe la chaîne directement sans DB::raw()
        $columns = DB::select("SHOW COLUMNS FROM users WHERE Field = 'sexe'");

        if (empty($columns)) {
            return [];
        }

        $type = $columns[0]->Type;

        // Extrait les valeurs entre parenthèses
        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $values = [];
        foreach (explode(',', $matches[1]) as $value) {
            $values[] = trim($value, "'");
        }

        return $values;
    }
}
