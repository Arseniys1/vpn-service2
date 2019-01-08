<?php

namespace App\Http\Controllers;

use App\Events\DeleteAccessEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\VpnServerLog;
use App\Events\CreateAccessEvent;
use App\VpnServer;
use Illuminate\Support\Facades\Auth;
use App\VpnServerAccess;

class ServersAccessController extends Controller
{
    public function createAccess(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip|exists:vpn_servers,ip',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'code' => 1,
                'message' => 'Validation failed.',
                'errors' => $v->errors()->toArray(),
            ]);
        }

        if (!Auth::user()->hasActiveAccess()) {
            return response()->json([
                'ok' => false,
                'code' => 5,
                'message' => 'You do not have an active subscription.',
            ]);
        }

        Auth::user()->makeHidden([
            'access',
        ]);

        $vpnServer = VpnServer::where('ip', '=', $request->input('ip'))->first();

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

        event(new CreateAccessEvent($vpnLog->event_id, $request->input('ip'), Auth::user()));

        return response()->json([
            'ok' => true,
            'code' => 4,
            'message' => 'Request send.',
            'event_id' => $vpnLog->event_id,
        ]);
    }

    public function removeAccess(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip|exists:vpn_servers,ip',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'code' => 1,
                'message' => 'Validation failed.',
                'errors' => $v->errors()->toArray(),
            ]);
        }

        $vpnServer = VpnServer::where('ip', '=', $request->input('ip'))->first();

        $vpnLogReq = VpnServerLog::where('vpn_server_id', '=', $vpnServer->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'request')
            ->where('action', '=', 'delete-access')
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

        if (!$serverAccess) {
            return response()->json([
                'ok' => false,
                'code' => 3,
                'message' => 'You do not have access to this server.',
            ]);
        }

        $vpnLog = new VpnServerLog();
        $vpnLog->vpn_server_id = $vpnServer->id;
        $vpnLog->user_id = Auth::user()->id;
        $vpnLog->type = 'request';
        $vpnLog->action = 'delete-access';
        $vpnLog->save();

        event(new DeleteAccessEvent($vpnLog->event_id, $request->input('ip'), Auth::user()));

        return response()->json([
            'ok' => true,
            'code' => 4,
            'message' => 'Request send.',
            'event_id' => $vpnLog->event_id,
        ]);
    }

    public function checkResponse(Request $request) {
        $v = Validator::make($request->all(), [
            'event_id' => 'required|string',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'code' => 1,
                'message' => 'Validation failed.',
                'errors' => $v->errors()->toArray(),
            ]);
        }

        $vpnServersLogReq = VpnServerLog::where('event_id', '=', $request->input('event_id'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'request')
            ->first();

        if (!$vpnServersLogReq) {
            return response()->json([
                'ok' => false,
                'code' => 2,
                'message' => 'Request not found.',
            ]);
        }

        $vpnServersLogRes = VpnServerLog::where('event_id', '=', $request->input('event_id'))
            ->where('type', '=', 'response')
            ->first();

        if ($vpnServersLogRes) {
            return response()->json([
                'ok' => true,
                'code' => 4,
                'message' => 'Response received.',
            ]);
        } else {
            return response()->json([
                'ok' => false,
                'code' => 3,
                'message' => 'No response received.',
            ]);
        }
    }
}
