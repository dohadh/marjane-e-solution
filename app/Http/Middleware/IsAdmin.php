<?php

// app/Http/Middleware/IsAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            // Rediriger l'utilisateur non-admin vers une page appropriée, comme une page d'erreur ou le tableau de bord.
            return redirect('/dashboard');
        }

        return $next($request);
    }
}


