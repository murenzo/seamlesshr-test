<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiTokenCheck extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (!$this->auth->parseToken()->authenticate()) {
                return response()->json(['status' => 401, 'message' => 'User unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['status' => 401, 'message' => 'User unauthorized'], 401);
        }

        return $next($request);
    }
}
