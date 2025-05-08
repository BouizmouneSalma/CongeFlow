<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. D'abord, mettre à jour les valeurs NULL en 0
        DB::statement("UPDATE types SET paiement = '0' WHERE paiement IS NULL");
        
        // 2. Pour PostgreSQL, convertir en numeric avec USING
        DB::statement("ALTER TABLE types ALTER COLUMN paiement TYPE numeric(5,2) USING (CASE 
            WHEN paiement ~ '^[0-9]+(\.[0-9]+)?$' THEN paiement::numeric 
            WHEN paiement = '100%' THEN '100'::numeric 
            WHEN paiement = '0%' THEN '0'::numeric 
            ELSE '0'::numeric 
        END)");
        
        // 3. Ajouter la contrainte NOT NULL et la valeur par défaut
        DB::statement('ALTER TABLE types ALTER COLUMN paiement SET NOT NULL');
        DB::statement('ALTER TABLE types ALTER COLUMN paiement SET DEFAULT 0');
    }

    public function down(): void
    {
        // Revenir à une colonne string nullable
        DB::statement('ALTER TABLE types ALTER COLUMN paiement TYPE varchar');
        DB::statement('ALTER TABLE types ALTER COLUMN paiement DROP NOT NULL');
        DB::statement('ALTER TABLE types ALTER COLUMN paiement DROP DEFAULT');
    }
}; 