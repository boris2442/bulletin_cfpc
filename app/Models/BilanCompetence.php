<?php

namespace App\Models;

use App\Models\User;
use App\Models\Module;
use App\Models\Specialite;
use Illuminate\Http\Request;
use App\Models\AnneeAcademique;
use Illuminate\Database\Eloquent\Model;

class BilanCompetence extends Model
{
    // AJOUTEZ CECI : Indique que la table n'a pas d'ID auto-incrémenté standard
// AJOUTEZ CES DEUX LIGNES
    protected $primaryKey = null; // Indique qu'il n'y a pas de clé primaire unique
    public $incrementing = false; // Désactive l'auto-incrémentation
 protected $table = 'bilan_competences'; // On précise le nom exact

    protected $fillable = [
        'user_id',
        'annee_academique_id',
        'moyenne_semestre1',
        'moyenne_semestre2',
        'moyenne_generale',
        'moyenne_competences', // Si tu l'utilises pour la moyenne CC (30%)
        'observations'
    ];
}
