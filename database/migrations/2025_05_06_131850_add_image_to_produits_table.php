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
        Schema::table('produits', function (Blueprint $table) {
            $table->string('image')->nullable();  // Colonne pour l'image principale
        });

        // Si vous souhaitez avoir plusieurs images par produit, créez une table d'images séparée
        Schema::create('produit_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained()->onDelete('cascade'); // Clé étrangère vers produits
            $table->string('image'); // Chemin de l'image
            $table->integer('ordre')->default(0); // Ordre des images
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Supprimer la table des images si elle a été créée
        Schema::dropIfExists('produit_images');

        // Supprimer la colonne image de la table produits
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
