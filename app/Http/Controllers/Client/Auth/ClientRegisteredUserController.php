<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClientRegisteredUserController extends Controller
{
    // Affiche le formulaire d'inscription client
    public function create()
    {
        return view('client.auth.register');
    }

    // Traite l'inscription client
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('clientsc')->login($client);

        return redirect(route('clients.dashboard'));
    }
}
