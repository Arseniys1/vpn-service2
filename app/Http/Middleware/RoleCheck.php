<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) return response('Not auth');

        $user = Auth::user();

        foreach ($roles as $role) {
            if (!$user->hasRole($role)) {
                return response('No role ' . $role);
            }
        }

        return $next($request);
    }
}
