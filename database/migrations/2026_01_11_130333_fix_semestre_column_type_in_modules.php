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
            // On change le type de la colonne pour accepter du texte (S1, S2)
            $table->string('semestre')->default('S1')->change();
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->integer('semestre')->change();
        });
    }
};
