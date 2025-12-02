<?php

namespace App\Http\Middleware;

use Closure;

class ForceJsonResponse
{
    public function handle($request, Closure $next)
    {
        // Set header agar response error selalu JSON
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
