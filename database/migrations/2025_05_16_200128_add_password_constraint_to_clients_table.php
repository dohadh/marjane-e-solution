
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordConstraintToClientsTable extends Migration
{
    public function up()
    {
        // 1. Rend le mot de passe obligatoire
        Schema::table('clients', function (Blueprint $table) {
            $table->string('password')->nullable(false)->change();
        });

        // 2. Ajoute l'index email (dans une nouvelle closure)
        Schema::table('clients', function (Blueprint $table) {
            $table->index('email'); // Correction ici
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->dropIndex(['email']);
        });
    }
}