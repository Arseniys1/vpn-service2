<?php

namespace App\Http\Controllers\Api\PublicApi\VpnServers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\VpnServerAccess;
use Illuminate\Support\Facades\Auth;

class GetOvpnConfig extends Controller
{
    public function getOvpnConfig(Request $request) {
        $v = Validator::make($request->all(), [
            'id' => 'required|integer|exists:vpn_servers,id'
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $v->errors(),
            ], 500);
        }

        if (!Auth::user()->hasActiveAccess()) {
            return response()->json([
                'ok' => false,
                'message' => 'No active subscription',
            ], 500);
        }

        $ovpnConfig = VpnServerAccess::where('vpn_server_id', '=', $request->input('id'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'open')
            ->first();

        if (!$ovpnConfig) {
            return response()->json([
                'ok' => false,
                'message' => 'No access to this server',
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'ovpn' => $ovpnConfig->ovpn,
        ]);
    }
}
