<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;


class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/home';  // Définir la redirection après réinitialisation

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $response = Password::reset($credentials, function ($user) use ($request) {
            $user->password = bcrypt($request->password);
            $user->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Mot de passe réinitialisé.');
        } else {
            return back()->withErrors(['email' => 'L\'email fourni est invalide ou expiré.']);
        }
    }
}
