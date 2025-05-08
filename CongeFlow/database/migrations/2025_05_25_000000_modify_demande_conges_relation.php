<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ajouter la nouvelle colonne conge_id comme nullable d'abord
        Schema::table('demande_conges', function (Blueprint $table) {
            $table->foreignId('conge_id')->nullable()->after('user_id');
        });

        // Créer des congés pour chaque type existant et mettre à jour les demandes
        $demandes = DB::table('demande_conges')->get();
        foreach ($demandes as $demande) {
            // Créer un nouveau congé basé sur le type
            $type = DB::table('types')->find($demande->type_id);
            if ($type) {
                $congeId = DB::table('conges')->insertGetId([
                    'titre' => $type->libelle,
                    'description' => $type->description,
                    'dateCreation' => now(),
                    'type_id' => $type->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ], 'idConge');  // Spécifier que idConge est la colonne d'auto-incrémentation

                // Mettre à jour la demande avec le nouveau conge_id
                DB::table('demande_conges')
                    ->where('id', $demande->id)
                    ->update(['conge_id' => $congeId]);
            }
        }

        // Rendre conge_id non nullable et ajouter la contrainte de clé étrangère
        Schema::table('demande_conges', function (Blueprint $table) {
            $table->foreignId('conge_id')->nullable(false)->change();
            $table->foreign('conge_id')->references('idConge')->on('conges')->onDelete('cascade');
            
            // Supprimer l'ancienne clé étrangère et colonne
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');

            // Ajouter la date de demande
            $table->timestamp('dateDemande')->after('conge_id')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_conges', function (Blueprint $table) {
            // Ajouter d'abord type_id comme nullable
            $table->foreignId('type_id')->nullable();
        });

        // Restaurer les relations type_id basées sur les congés
        $demandes = DB::table('demande_conges')->get();
        foreach ($demandes as $demande) {
            $conge = DB::table('conges')->where('idConge', $demande->conge_id)->first();
            if ($conge) {
                DB::table('demande_conges')
                    ->where('id', $demande->id)
                    ->update(['type_id' => $conge->type_id]);
            }
        }

        Schema::table('demande_conges', function (Blueprint $table) {
            // Rendre type_id non nullable et ajouter la contrainte
            $table->foreignId('type_id')->nullable(false)->change();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');

            // Supprimer les nouvelles colonnes
            $table->dropForeign(['conge_id']);
            $table->dropColumn(['conge_id', 'dateDemande']);
        });
    }
}; 