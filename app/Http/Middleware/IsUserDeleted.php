<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;


class IsUserDeleted
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

        if ($request->user()->deleted_at) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
