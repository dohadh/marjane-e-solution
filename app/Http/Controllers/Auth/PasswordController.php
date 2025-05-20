<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Password as PasswordFacade;

class PasswordController extends Controller
{
    /**
     * Afficher la vue de réinitialisation de mot de passe.
     */
    public function show(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->route('token'), 'email' => $request->email]);
    }

    /**
     * Mettre à jour le mot de passe de l'utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        // Valider les données
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'token' => ['required'],
        ]);

        // Vérifier le token de réinitialisation du mot de passe
        $status = PasswordFacade::reset(
            $validated,
            function ($user) use ($validated) {
                $user->forceFill([
                    'password' => Hash::make($validated['password']),
                ])->save();
            }
        );

        // Vérifier si la réinitialisation a réussi
        if ($status == PasswordFacade::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __('Your password has been reset.'));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
