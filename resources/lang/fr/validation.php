<?php

return [
    // Règles de validation
    'required' => 'Le champ :attribute est obligatoire.',
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',

    // Messages personnalisés (optionnel)
    'custom' => [
        'password' => [
            'min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'confirmed' => 'Les mots de passe ne correspondent pas.',
        ],
    ],

    // ✅ Fusion de tous les attributs personnalisés ici
    'attributes' => [
        // Fournisseur
        'email' => 'Email',
        'nom' => 'Nom',
        'telephone' => 'Téléphone',
        'adresse' => 'Adresse',
        'password' => 'Mot de passe',

        // Facture
        'numero' => 'Numéro de facture',
        'client_id' => 'Client',
        'date_facture' => 'Date de facture',
        'montant_total' => 'Montant total',
        'statut' => 'Statut',
        'description' => 'Description',
        'date_echeance' => 'Date d\'échéance',
        'products' => 'Produits',
        'products.*.product_id' => 'Produit',
        'products.*.quantity' => 'Quantité',
        'products.*.price' => 'Prix unitaire',

        // Produits
        'reference' => 'Référence',
        'type' => 'Type de produit',
        'prix_unitaire' => 'Prix unitaire',
        'quantite_en_stock' => 'Quantité en stock',
        'seuil_alerte' => 'Seuil d\'alerte',
        'image' => 'Nom de l\'image',

        // Vente
        'produits' => 'produits',
        'produits.*.id' => 'produit',
        'produits.*.quantite' => 'quantité',
        'produits.*.prix_vente' => 'prix de vente',
        'date_vente' => 'date de vente',
    ],
];
