<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login'); // Assure-toi que cette vue existe
    }
        /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $host = $request->getHost(); 
        $subdomain = explode('.', $host)[0];

        if ($subdomain === 'client') {
            // Redirige vers la route affichant le dashboard client
            return redirect()->route('clients.dashboard');
        } else {
            // Par défaut, dashboard général (admin, etc.)
            return redirect()->route('dashboard');
        }
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');  // Ou vers la page de connexion
    }

    public function __construct()
    {
        $this->middleware('guest')->except('destroy');  // Le middleware guest s'assure que l'utilisateur non authentifié accède à cette page
    }
}
