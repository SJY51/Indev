<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Helpers\Arrays;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Jwt extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards): mixed
    {
        $middlewares = $request->route()->getAction('middleware') ?? [];
        $authExists = Arrays::oneOfSeveralInArray(['api', 'auth:api', 'auth'], $middlewares);

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $exception) {
            try {
                $token = JWTAuth::parseToken()->refresh();
            } catch (Exception $exception) {
                if ($authExists) {
                    return response()->json(['message' => 'Unauthenticated.'], 401);
                } else {
                    return $next($request);
                }
            }

            auth('api')->setToken($token);

            $response = $next($request);
            $response->headers->set('Authorization', 'Bearer ' . $token);

            return $response;
        }

        return $next($request);
    }
}
