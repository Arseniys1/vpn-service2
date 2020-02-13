<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\VpnServer;

class VpnPathController extends Controller
{
    public function index(Request $request) {
        $servers = VpnServer::where('free', '=', false)->get();

        return view('cabinet.vpn_path_configure')->with([
            'servers' => $servers,
        ]);
    }
}
