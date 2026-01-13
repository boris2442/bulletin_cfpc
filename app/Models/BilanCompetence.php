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
