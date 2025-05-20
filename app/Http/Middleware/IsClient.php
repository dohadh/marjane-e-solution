<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie que l'utilisateur est connecté ET que son rôle est 'client'
        if (Auth::check() && Auth::user()->role === 'client') {
            return $next($request);
        }

        // Sinon, redirige vers la page d'accueil avec un message d'erreur
        return redirect('/')->with('error', "Accès réservé aux clients.");
    }
}
