<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
        // 1. Nettoyage de la table MODULES
        if (Schema::hasTable('modules')) {
            Schema::table('modules', function (Blueprint $table) {
                // Supprimer la colonne classe_id si elle existe
                if (Schema::hasColumn('modules', 'classe_id')) {
                    try {
                        // On force la suppression de la clé étrangère sans vérifier le nom
                        DB::statement('ALTER TABLE modules DROP FOREIGN KEY modules_classe_id_foreign');
                    } catch (\Exception $e) {}
                    $table->dropColumn('classe_id');
                }
                
                // Supprimer l'ancien index unique d'ordre qui bloque
                try {
                    DB::statement('ALTER TABLE modules DROP INDEX modules_specialite_id_ordre_unique');
                } catch (\Exception $e) {}

                // Ajouter semestre si absent
                if (!Schema::hasColumn('modules', 'semestre')) {
                    $table->enum('semestre', ['S1', 'S2'])->default('S1')->after('coef_module');
                }
            });
        }

        // 2. Nettoyage de la table INSCRIPTIONS
        if (Schema::hasTable('inscriptions')) {
            Schema::table('inscriptions', function (Blueprint $table) {
                if (Schema::hasColumn('inscriptions', 'classe_id')) {
                    try {
                        DB::statement('ALTER TABLE inscriptions DROP FOREIGN KEY inscriptions_classe_id_foreign');
                    } catch (\Exception $e) {}
                    $table->dropColumn('classe_id');
                }
            });
        }

        // 3. SUPPRESSION DÉFINITIVE de la table classes
        Schema::dropIfExists('classes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
