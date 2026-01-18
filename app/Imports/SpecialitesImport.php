<?php

namespace App\Imports;

use App\Models\Specialite;
use Maatwebsite\Excel\Concerns\ToModel;

class SpecialitesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Specialite([
      'nom_specialite' => $row['nom'],        // Le nom de la colonne dans Excel doit être "nom"
            'code_unique'    => $row['code'],       // Le nom de la colonne dans Excel doit être "code"
            'description'    => $row['description'] // Optionnel
        ]);
    }
}
