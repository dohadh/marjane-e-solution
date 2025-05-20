<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique(); // Numéro de facture
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Référence au client
            $table->date('date_facture'); // Date de la facture
            $table->decimal('montant_total', 10, 2); // Montant total de la facture
            $table->enum('statut', ['en attente', 'payée']); // Statut de la facture
            $table->timestamps(); // created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
}
