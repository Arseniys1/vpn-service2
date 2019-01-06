<?php

namespace App\Http\Controllers\Echoo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServer;
use App\VpnServerLog;
use Illuminate\Support\Facades\Validator;

class DeleteAccessController extends Controller
{
    public function deleteAccess(Request $request) {
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

        $vpnServerLog = new VpnServerLog();
        $vpnServerLog->event_id = $data['data']['event_id'];
        $vpnServerLog->vpn_server_id = $vpnServer->id;
        $vpnServerLog->user_id = $data['data']['user']['id'];
        $vpnServerLog->type = 'response';
        $vpnServerLog->action = 'delete-access';
        $vpnServerLog->data = $request->input('data');
        $vpnServerLog->save();

        return response()->json([
            'ok' => true,
            'message' => 'Success.'
        ]);
    }
}
