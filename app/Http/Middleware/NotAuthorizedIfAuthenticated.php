<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotAuthorizedIfAuthenticated
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
    public function handle(Request $request, Closure $next, $guard = null): mixed
    {
        if (Auth::guard($guard)->check()) {
            return response()->json(['error' => 'You are logged in.']);
        }

        return $next($request);
    }
}