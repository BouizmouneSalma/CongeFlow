<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('types', function (Blueprint $table) {
            // Ajouter la colonne paiement
            $table->text('paiement')->nullable();
            
            // Ajouter une colonne pour le type de paiement (CNSS, employeur, etc.)
            $table->string('source_paiement')->nullable();
            
            // Ajouter une colonne pour le pourcentage de paiement
            $table->string('taux_paiement')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            // Supprimer les colonnes
            $table->dropColumn(['paiement', 'source_paiement', 'taux_paiement']);
        });
    }
}; 