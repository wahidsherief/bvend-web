<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTRoleAuth extends BaseMiddleware {
    public function handle($request, Closure $next, $role = null)
    {
        try {
            $this->auth->parseToken()->getClaim('role');
        } catch (JWTException $e) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        
        if ($token_role = $role) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        
        return $next($request);
    }
}

?>