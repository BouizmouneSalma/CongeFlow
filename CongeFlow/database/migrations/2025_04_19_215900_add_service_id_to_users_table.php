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
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la colonne service existante si elle existe
            if (Schema::hasColumn('users', 'service')) {
                $table->dropColumn('service');
            }
            
            // Ajouter la colonne service_id comme clé étrangère
            $table->foreignId('service_id')->nullable()->after('role')
                  ->constrained('services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
            $table->string('service')->nullable()->after('role');
        });
    }
};
