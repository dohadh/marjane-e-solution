<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if (method_exists($user, 'hasRole') && ($user->hasRole('admin') || $user->hasRole('user'))) {
                session(['user_type' => 'user']);
            }
        }
        elseif (Auth::guard('client')->check()) {
            session(['user_type' => 'client']);
        }

        return $next($request);
    }
}
