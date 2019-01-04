<?php

namespace App\Http\Middleware;

use Closure;
use App\EchoServer;

class EchoServerVerify
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
        $echoServer = EchoServer::where('token', '=', $request->route('token'))->first();

        if (!$echoServer) {
            return response('Not Auth', 401);
        }

        return $next($request);
    }
}
