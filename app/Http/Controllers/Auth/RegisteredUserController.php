<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        // Crée un utilisateur avec les données validées
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Connecte l'utilisateur après l'inscription
        Auth::login($user);

        // Redirige vers la page d'accueil ou autre
        return redirect(RouteServiceProvider::HOME);

    }


    public function __construct()
    {
        $this->middleware('guest'); // Assure-toi que les utilisateurs authentifiés ne peuvent pas accéder à cette page
    }
}

