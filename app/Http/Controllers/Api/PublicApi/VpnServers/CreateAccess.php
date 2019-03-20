<?php

namespace App\Http\Controllers\Api\PublicApi\VpnServers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\VpnServer;
use App\VpnServerLog;
use App\VpnServerAccess;
use App\Events\CreateAccessEvent;

class CreateAccess extends Controller
{
    public function createAccess(Request $request) {
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

        $vpnServer = VpnServer::where('id', '=', $request->input('id'))->first();

        if (!$vpnServer->online) {
            return response()->json([
                'ok' => false,
                'code' => 6,
                'message' => 'Server offline.',
            ]);
        }

        if (!Auth::user()->hasActiveAccess() && !$vpnServer->free) {
            return response()->json([
                'ok' => false,
                'code' => 5,
                'message' => 'You do not have an active subscription.',
            ]);
        }

        Auth::user()->makeHidden([
            'access',
        ]);

        $vpnLogReq = VpnServerLog::where('vpn_server_id', '=', $vpnServer->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'request')
            ->where('action', '=', 'create-access')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($vpnLogReq) {
            $vpnLogRes = VpnServerLog::where('event_id', '=', $vpnLogReq->event_id)
                ->where('type', '=', 'response')
                ->first();

            if (!$vpnLogRes) {
                return response()->json([
                    'ok' => false,
                    'code' => 2,
                    'message' => 'Request already sent.',
                    'event_id' => $vpnLogReq->event_id,
                ]);
            }
        }

        $serverAccess = VpnServerAccess::where('vpn_server_id', '=', $vpnServer->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'open')
            ->first();

        if ($serverAccess) {
            return response()->json([
                'ok' => false,
                'code' => 3,
                'message' => 'Already have access to the server.',
            ]);
        }

        $vpnLog = new VpnServerLog();
        $vpnLog->vpn_server_id = $vpnServer->id;
        $vpnLog->user_id = Auth::user()->id;
        $vpnLog->type = 'request';
        $vpnLog->action = 'create-access';
        $vpnLog->save();

        event(new CreateAccessEvent($vpnLog->event_id, $vpnServer->ip, Auth::user()));

        return response()->json([
            'ok' => true,
            'code' => 4,
            'message' => 'Request send.',
            'event_id' => $vpnLog->event_id,
        ]);
    }
}
