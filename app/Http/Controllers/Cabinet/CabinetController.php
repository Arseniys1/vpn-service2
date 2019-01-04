<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\VpnServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class CabinetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        App::setLocale(Auth::user()->locale);

        return view('cabinet.cab')->with([
            'vpnServers' => VpnServer::get(),
        ]);
    }

    public function downloadOvpnConfig(Request $request)
    {
        $vpnServer = VpnServer::where('id', '=', $request->route('server_id'))->first();

        if ($vpnServer == null || $vpnServer->ovpn_config == null) {
            return response('No config', 404);
        }

        $ovpn_config = $vpnServer->ovpn_config;

        $ovpn_config = str_replace(':ip', $vpnServer->ip, $ovpn_config);
        $ovpn_config = str_replace(':port', $vpnServer->port, $ovpn_config);

        $filename = $vpnServer->country->name . ' ' . $vpnServer->country->iso . ' ' . $vpnServer->ip . '_' . $vpnServer->port . '.ovpn';

        return response($ovpn_config)->header('Content-Description', 'File Transfer')
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Content-Transfer-Encoding', 'binary')
            ->header('Expires', '0')
            ->header('Cache-Control', 'must-revalidate')
            ->header('Pragma', 'Public')
            ->header('Content-Length', strlen($ovpn_config));
    }
}
