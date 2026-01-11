<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up(): void
{
    Schema::table('modules', function (Blueprint $table) {
        // On ajoute "nullable()" pour éviter l'erreur de contrainte sur les données existantes
        // On place la colonne après 'id' ou 'nom_module' pour la visibilité
        $table->foreignId('specialite_id')
              ->nullable() 
              ->after('id') 
              ->constrained('specialites')
              ->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('modules', function (Blueprint $table) {
        $table->dropForeign(['specialite_id']);
        $table->dropColumn('specialite_id');
    });
}
};
