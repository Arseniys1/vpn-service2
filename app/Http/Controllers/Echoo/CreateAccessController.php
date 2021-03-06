<?php

namespace App\Http\Controllers\Echoo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServer;
use App\VpnServerLog;
use App\VpnServerAccess;
use Illuminate\Support\Facades\Validator;

class CreateAccessController extends Controller
{
    public function createAccess(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip',
            'data' => 'required|string|json',
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

        $data = json_decode($request->input('data'), true);

        $vpnServerAccess = VpnServerAccess::where('vpn_server_id', '=', $vpnServer->id)
            ->where('user_id', '=', $data['data']['user']['id'])
            ->where('status', '=', 'open')
            ->first();

        if ($vpnServerAccess) {
            return response()->json([
                'ok' => false,
                'message' => 'Already have access to the server.'
            ]);
        }

        $vpnServerLog = new VpnServerLog();
        $vpnServerLog->event_id = $data['data']['event_id'];
        $vpnServerLog->vpn_server_id = $vpnServer->id;
        $vpnServerLog->user_id = $data['data']['user']['id'];
        $vpnServerLog->type = 'response';
        $vpnServerLog->action = 'create-access';
        $vpnServerLog->data = $request->input('data');
        $vpnServerLog->save();

        $vpnServerAccess = new VpnServerAccess();
        $vpnServerAccess->vpn_servers_log_id = $vpnServerLog->id;
        $vpnServerAccess->vpn_server_id = $vpnServer->id;
        $vpnServerAccess->user_id = $vpnServerLog->user_id;
        $vpnServerAccess->ovpn = $data['data']['ovpn'];
        $vpnServerAccess->status = 'open';
        $vpnServerAccess->save();

        return response()->json([
            'ok' => true,
            'message' => 'Success.'
        ]);
    }
}
