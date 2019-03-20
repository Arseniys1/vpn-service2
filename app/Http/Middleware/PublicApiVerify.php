<?php

namespace App\Http\Middleware;

use Closure;
use App\UserApplication;
use Illuminate\Support\Facades\Auth;

class PublicApiVerify
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
        $application = UserApplication::where('token', '=', $request->route('token'))->first();

        if (!$application) {
            return response()->json([
                'ok' => false,
                'message' => 'Wrong application token'
            ], 401);
        }

        Auth::login($application->user);

        return $next($request);
    }
}
