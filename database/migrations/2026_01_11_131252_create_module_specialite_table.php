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
        // 1. Création de la table pivot
        Schema::create('module_specialite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->foreignId('specialite_id')->constrained()->onDelete('cascade');

            // On déplace les infos spécifiques au parcours ici
            $table->string('semestre')->default('S1');
            $table->integer('ordre')->default(1);

            $table->timestamps();
        });

        // 2. Nettoyage de la table modules (on enlève ce qui a migré vers la pivot)
        Schema::table('modules', function (Blueprint $table) {
            // On vérifie si les colonnes existent avant de les supprimer pour éviter les erreurs
            if (Schema::hasColumn('modules', 'specialite_id')) {
                $table->dropForeign(['specialite_id']);
                $table->dropColumn('specialite_id');
            }
            if (Schema::hasColumn('modules', 'semestre')) {
                $table->dropColumn('semestre');
            }
            if (Schema::hasColumn('modules', 'ordre')) {
                $table->dropColumn('ordre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('specialite_id')->nullable()->constrained();
            $table->string('semestre')->default('S1');
            $table->integer('ordre')->default(1);
        });

        Schema::dropIfExists('module_specialite');
    }
};
