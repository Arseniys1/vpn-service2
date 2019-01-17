<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\VpnServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\VpnServerAccess;

class CabinetController extends Controller
{
    public function index()
    {
        return view('cabinet.cab');
    }

    public function downloadConfig(Request $request)
    {
        $vpnServer = VpnServer::where('ip', '=', $request->route('ip'))->first();

        if (!$vpnServer) {
            return response('Server not found');
        }

        $vpnServerAccess = VpnServerAccess::where('vpn_server_id', '=', $vpnServer->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'open')
            ->first();

        if (!$vpnServerAccess) {
            return response('You do not have access to the server');
        }

        $filename = $vpnServer->country->name . ' ' . $vpnServer->country->iso . ' ' . $vpnServer->ip . '_' . $vpnServer->port . '.ovpn';

        return response($vpnServerAccess->ovpn)->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate')
            ->header('Pragma', 'Public')
            ->header('Content-Length', strlen($vpnServerAccess->ovpn));
    }
}
