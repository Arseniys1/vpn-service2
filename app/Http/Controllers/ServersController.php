<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VpnServer;

class ServersController extends Controller
{
    public function index(Request $request) {
        $servers = VpnServer::where('free', '=', false)
            ->with('country')
            ->simplePaginate(15);

        foreach ($servers as $server) {
            $server->append('have_access');

            $server->makeHidden([
                'online',
                'show',
                'banned',
                'cpu',
                'ram',
                'hdd',
                'created_at',
                'updated_at',
            ]);
        }

        return view('servers')->with([
            'title' => 'servers_title',
            'servers' => $servers,
        ]);
    }

    public function free(Request $request) {
        $servers = VpnServer::where('free', '=', true)
            ->with('country')
            ->simplePaginate(15);

        foreach ($servers as $server) {
            $server->append('have_access');

            $server->makeHidden([
                'online',
                'show',
                'banned',
                'cpu',
                'ram',
                'hdd',
                'created_at',
                'updated_at',
            ]);
        }

        return view('servers')->with([
            'title' => 'free_servers_title',
            'servers' => $servers,
        ]);
    }
}
