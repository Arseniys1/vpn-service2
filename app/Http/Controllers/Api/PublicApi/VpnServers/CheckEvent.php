<?php

namespace App\Http\Controllers\Api\PublicApi\VpnServers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServerLog;
use Illuminate\Support\Facades\Validator;

class CheckEvent extends Controller
{
    public function checkEvent(Request $request) {
        $v = Validator::make($request->all(), [
            'event_id' => 'required|string|exists:vpn_servers_log,event_id'
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $v->errors(),
            ], 500);
        }

        $vpnServersLogResponse = VpnServerLog::where('event_id', '=', $request->input('event_id'))
            ->where('type', '=', 'response')
            ->first();

        if (!$vpnServersLogResponse) {
            return response()->json([
                'ok' => true,
                'response_received' => false
            ]);
        }

        return response()->json([
            'ok' => true,
            'response_received' => true
        ]);
    }
}
