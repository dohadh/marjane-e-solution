<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Contrôle le guard et les paramètres de reset de mot de passe par défaut.
    |
    */

    'defaults' => [
        'guard' => 'web',          // Utilisateur par défaut (admin)
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Chaque guard gère la façon dont l'utilisateur est authentifié.
    | Ici on définit un guard pour admin (web) et un pour client.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',   // Admins dans la table users
        ],

        'client' => [
            'driver' => 'session',
            'provider' => 'clients', // Clients dans la table clients
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Définit comment récupérer les utilisateurs depuis la base de données.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,    // Modèle admin
        ],

        'clients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Client::class,  // Modèle client
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configuration pour la réinitialisation des mots de passe.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'clients' => [
            'provider' => 'clients',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Temps avant expiration de la confirmation de mot de passe.
    |
    */

    'password_timeout' => 10800,

];
