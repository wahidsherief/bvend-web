<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers('Access-Control-Allow-Origin', '*');
        $response->headers('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}
