<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubdomain
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        if (str_starts_with($host, 'admin.')) {
            // Définit un flag dans la session ou request pour admin
            $request->attributes->set('subdomain', 'admin');
        } elseif (str_starts_with($host, 'client.')) {
            $request->attributes->set('subdomain', 'client');
        } else {
            $request->attributes->set('subdomain', 'default');
        }

        return $next($request);
    }
}
