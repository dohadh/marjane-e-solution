<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenteProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vente_produit')) {
            Schema::create('vente_produit', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vente_id')->constrained()->onDelete('cascade');
                $table->foreignId('produit_id')->constrained()->onDelete('cascade');
                $table->integer('quantite');
                $table->decimal('prix_vente', 10, 2);
                $table->timestamps();
            });
        }
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vente_produit');
    }
}
