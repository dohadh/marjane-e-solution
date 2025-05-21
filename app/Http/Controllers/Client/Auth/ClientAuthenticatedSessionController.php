<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthenticatedSessionController extends Controller
{
    // Affiche le formulaire de connexion client
    public function create()
    {
        return view('clients.auth.client-login');
    }

    // Traite la tentative de connexion client
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('client')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('clients.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les informations d’identification sont incorrectes.',
        ]);
    }

    // Déconnecte le client
    public function destroy(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('clients.login'));
    }
}
