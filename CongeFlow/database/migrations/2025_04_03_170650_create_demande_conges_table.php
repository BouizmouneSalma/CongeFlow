<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demande_conges', function (Blueprint $table) {
            $table->id('idDemande');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('conge_id')->constrained('conges', 'idCours')->onDelete('cascade');
            $table->timestamp('dateDemande');
            $table->string('status')->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demande_conges');
    }
};