<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{

    /**
     * @param $request
     * @param Closure $next
     * @param array ...$roles
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
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
