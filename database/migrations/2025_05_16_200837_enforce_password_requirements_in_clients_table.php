<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('clients', function (Blueprint $table) {
        // 1. Rend le champ obligatoire
        $table->string('password')->nullable(false)->change();
        
        // 2. Ajoute une vérification de format
        DB::statement("ALTER TABLE clients ADD CONSTRAINT chk_password_format 
                      CHECK (password LIKE '$2y$%' OR password LIKE '$2a$%')");
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
};
