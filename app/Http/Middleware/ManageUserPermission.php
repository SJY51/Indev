<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;


class ManageUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$user->can('create users')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
