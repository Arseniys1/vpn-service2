<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServer;
use Illuminate\Support\Facades\Request as RequestFacade;

class ApiController extends Controller
{
    protected function ok($message = '') {
        return response()->json([
            'ok' => true,
            'message' => $message,
        ]);
    }

    protected function fail($message = '') {
        return response()->json([
            'ok' => false,
            'message' => $message,
        ]);
    }

    protected function getVpnServer() {
        return VpnServer::where('token', '=', RequestFacade::route('token'))->first();
    }
}
