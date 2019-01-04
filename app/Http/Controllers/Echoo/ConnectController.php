<?php

namespace App\Http\Controllers\Echoo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServer;
use App\VpnServerLog;
use Illuminate\Support\Facades\Validator;

class ConnectController extends Controller
{
    public function connect(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip',
            'token' => 'required|string',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed.',
                'errors' => $v->errors()->toArray(),
            ]);
        }

        $vpnServer = VpnServer::where('ip', '=', $request->input('ip'))
            ->where('token', '=', $request->input('token'))
            ->first();

        if (!$vpnServer) {
            return response()->json([
                'ok' => false,
                'message' => 'Wrong vpn server token.'
            ]);
        }

        $vpnServer->online = true;
        $vpnServer->save();

        $vpnServerLog = new VpnServerLog();
        $vpnServerLog->vpn_server_id = $vpnServer->id;
        $vpnServerLog->type = 'response';
        $vpnServerLog->action = 'connect';
        $vpnServerLog->save();

        return response()->json([
            'ok' => true,
            'message' => 'Success.'
        ]);
    }
}
