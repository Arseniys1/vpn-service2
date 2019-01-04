<?php

namespace App\Http\Middleware;

use Closure;
use App\VpnServer;

class VpnVerify
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
        $vpnServer = VpnServer::where('token', '=', $request->route('token'))->first();

        if ($vpnServer == null) {
            return response()->json([
                'ok' => false,
                'message' => 'Wrong token'
            ]);
        } else if ($vpnServer != null && $vpnServer->ip != $request->ip()) {
            return response()->json([
                'ok' => false,
                'message' => 'Wrong ip'
            ]);
        } else if ($vpnServer != null && $vpnServer->banned) {
            return response()->json([
                'ok' => false,
                'message' => 'Server banned'
            ]);
        }

        return $next($request);
    }
}
