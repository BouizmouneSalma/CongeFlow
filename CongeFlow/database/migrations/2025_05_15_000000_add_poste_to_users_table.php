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
            if (!Schema::hasColumn('users', 'poste')) {
                $table->string('poste')->nullable()->after('service_id');
            }
            
            if (!Schema::hasColumn('users', 'date_embauche')) {
                $table->date('date_embauche')->nullable()->after('poste');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'poste')) {
                $table->dropColumn('poste');
            }
            
            if (Schema::hasColumn('users', 'date_embauche')) {
                $table->dropColumn('date_embauche');
            }
        });
    }
}; 