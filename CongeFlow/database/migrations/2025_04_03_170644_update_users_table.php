<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nom');
            $table->string('prenom')->after('nom');
            $table->string('photoProfile')->nullable()->after('password');
            $table->string('role')->default('salarie');
            $table->string('status')->nullable();
            $table->timestamp('dateInscription')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prenom', 'photoProfile', 'role', 'status', 'dateInscription']);
        });
    }
};