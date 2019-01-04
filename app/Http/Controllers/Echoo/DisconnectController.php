<?php

namespace App\Http\Controllers\Echoo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServer;
use App\VpnServerLog;
use Illuminate\Support\Facades\Validator;

class DisconnectController extends Controller
{
    public function disconnect(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed.',
                'errors' => $v->errors()->toArray(),
            ]);
        }

        $vpnServer = VpnServer::where('ip', '=', $request->input('ip'))->first();

        if (!$vpnServer) {
            return response()->json([
                'ok' => false,
                'message' => 'Wrong vpn server ip.'
            ]);
        }

        $vpnServer->online = false;
        $vpnServer->save();

        $vpnServerLog = new VpnServerLog();
        $vpnServerLog->vpn_server_id = $vpnServer->id;
        $vpnServerLog->type = 'response';
        $vpnServerLog->action = 'disconnect';
        $vpnServerLog->save();

        return response()->json([
            'ok' => true,
            'message' => 'Success.'
        ]);
    }
}
