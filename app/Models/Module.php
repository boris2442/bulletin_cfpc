<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

protected $fillable = [

        'code_module', 
        'nom_module',
        'coef_module',
        'semestre',   // Ajouté pour S1/S2

        'is_bilan',   // Pour les examens de fin de formation
    ];

   

    // Relation Many-to-Many avec les enseignants (utilisateurs)
    public function enseignants()
    {
        return $this->belongsToMany(User::class, 'module_enseignant');
    }

    
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }


public function specialites()
{
    return $this->belongsToMany(Specialite::class, 'module_specialite')
                ->withPivot('semestre', 'ordre')
                ->withTimestamps();
}


    /**
     * Boot the model.
     * Logique de génération automatique du code unique M1, M2, etc.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($module) {
            // On cherche le max actuel pour générer le suivant (M1, M2...)
            $lastModule = self::query()
                ->selectRaw('MAX(CAST(SUBSTRING(code_module, 2) AS SIGNED)) as max_number')
                ->where('code_module', 'like', 'M%')
                ->first();

            $nextNumber = ($lastModule && $lastModule->max_number !== null) 
                          ? $lastModule->max_number + 1 
                          : 1;

            $module->code_module = 'M' . $nextNumber;
        });
    }
}
