<?php

// database/seeders/ProduitSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produit;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        Produit::create([
            'nom' => 'danette-DANON',
            'reference' => 'lll',
            'description' => 'eiii',
            'prix_unitaire' => 25,
            'quantite_en_stock' => 1000,
            'image' => 'danette.jpg',
        ]);

        //Produit::create([
            //'nom' => 'dklqs',
           // 'reference' => 'qsqs',
           // 'description' => 'sqs',
           // 'prix_unitaire' => 131.00,
           // 'quantite_en_stock' => 123,
           // 'seuil_alerte' => 5,
           // 'image' => 'produits/BbIxdx3nSYf9MxHTpaVLCdCYrL3LrHoFpWVHhSyp.webp',
       // ]);

        // Tu peux continuer à ajouter autant de produits que tu veux ici
    }
}
