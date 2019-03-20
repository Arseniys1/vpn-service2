<?php

namespace App\Http\Controllers\Api\PublicApi\VpnServers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServerAccess;
use Illuminate\Support\Facades\Auth;

class GetServersAccess extends Controller
{
    public function getServersAccess(Request $request) {
        $vpnServerAccess = VpnServerAccess::where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'open')
            ->get();

        return response()->json([
            'ok' => true,
            'servers_access' => $vpnServerAccess,
        ]);
    }
}
