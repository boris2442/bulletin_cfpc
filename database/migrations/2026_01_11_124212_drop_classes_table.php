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
     // 1. On retire d'abord la clé étrangère dans la table inscriptions
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropForeign(['classe_id']); 
            $table->dropColumn('classe_id');
        });

        // 2. On supprime enfin la table classes
        Schema::dropIfExists('classes');
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
    {
        // Au cas où tu voudrais revenir en arrière
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_classe');
            $table->foreignId('specialite_id')->constrained();
            $table->timestamps();
        });

        Schema::table('inscriptions', function (Blueprint $table) {
            $table->foreignId('classe_id')->nullable()->constrained();
        });
    }
};
