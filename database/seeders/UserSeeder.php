<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Créer un utilisateur avec le rôle "gestionnaire"
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password'),
            'role' => 'gestionnaire',  // Assignation du rôle
        ]);
    
        // Créer un utilisateur avec le rôle "user"
        User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',  // Role "user"
        ]);
    }
}
