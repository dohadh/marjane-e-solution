<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('client')->check()) {
            return $next($request);
        }

        return redirect(route('clients.login'))->with('error', "Accès réservé aux clients.");
    }
}
