<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('types', function (Blueprint $table) {
            // Ajouter la colonne duree comme string pour supporter des formats comme "1,5 jour/mois"
            $table->string('duree')->nullable()->after('description');
            // Ajouter la colonne duree_max pour stocker la durée maximale en jours
            $table->integer('duree_max')->nullable()->after('duree');
        });
    }

    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropColumn(['duree', 'duree_max']);
        });
    }
}; 