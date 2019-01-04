<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\VpnServerLog;
use App\Events\CreateAccessEvent;
use App\VpnServer;
use Illuminate\Support\Facades\Auth;

class ServersAccessController extends Controller
{
    public function createAccess(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip|exists:vpn_servers,ip',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed.',
                'errors' => $v->errors()->toArray(),
            ]);
        }

        $vpnServer = VpnServer::where('ip', '=', $request->input('ip'))->first();

        $vpnLog = new VpnServerLog();
        $vpnLog->vpn_server_id = $vpnServer->id;
        $vpnLog->user_id = Auth::user()->id;
        $vpnLog->type = 'request';
        $vpnLog->action = 'create-access';
        $vpnLog->save();

        event(new CreateAccessEvent($vpnLog->event_id, $request->input('ip'), Auth::user()->id));

        return response()->json([
            'ok' => true,
            'message' => 'Request send.',
        ]);
    }
}
