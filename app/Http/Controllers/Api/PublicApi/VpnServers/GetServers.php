<?php

namespace App\Http\Controllers\Api\PublicApi\VpnServers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VpnServer;
use Illuminate\Support\Facades\Validator;

class GetServers extends Controller
{
    private $limit = 10;
    private $offset = 0;

    public function getServers(Request $request) {
        $v = Validator::make($request->all(), [
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer',
        ]);

        if ($v->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $v->errors(),
            ], 500);
        }

        $request->has('limit') ? $this->limit = $request->input('limit') : null;
        $request->has('offset') ? $this->offset = $request->input('offset') : null;

        $servers = VpnServer::skip($this->offset)
            ->take($this->limit)
            ->with('country')
            ->get();

        return response()->json([
            'ok' => true,
            'servers' => $servers,
        ]);
    }
}
