<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VpnServer;

class ServersController extends Controller
{
    public function index(Request $request) {
        $servers = VpnServer::where('free', '=', false)->simplePaginate(15);

        return view('servers')->with([
            'title' => 'servers_title',
            'servers' => $servers,
        ]);
    }

    public function free(Request $request) {
        $servers = VpnServer::where('free', '=', true)->simplePaginate(15);

        return view('servers')->with([
            'title' => 'free_servers_title',
            'servers' => $servers,
        ]);
    }
}
