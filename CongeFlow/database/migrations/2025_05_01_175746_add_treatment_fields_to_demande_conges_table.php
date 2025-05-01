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
        Schema::table('demande_conges', function (Blueprint $table) {
            $table->timestamp('date_traitement')->nullable()->after('commentaire');
            $table->foreignId('traite_par')->nullable()->after('date_traitement')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_conges', function (Blueprint $table) {
            $table->dropColumn(['date_traitement', 'traite_par']);
        });
    }
};
