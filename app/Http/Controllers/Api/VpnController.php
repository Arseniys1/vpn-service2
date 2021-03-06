<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\VpnServerStatistics;
use App\VpnServerLog;

class VpnController extends ApiController
{
    public function verify(Request $request) {
        $v = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'ip' => 'required|string|ip',
            'port' => 'required|integer',
        ]);

        if ($v->fails()) {
            return $this->fail('Validation parameters failed');
        }

        $user = User::where('vpn_username', '=', $request->input('username'))->first();

        if ($user == null) {
            return $this->fail('User is not found');
        } else if ($user != null && $user->vpn_password != $request->input('password')) {
            return $this->fail('Wrong password');
        } else if ($user != null && !$user->hasActiveAccess()) {
            return $this->fail('No active subscription');
        }

        return $this->ok('Authorized');
    }

    public function connect(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip',
            'user_text_id' => 'required|string',
        ]);

        if ($v->fails()) {
            return $this->fail('Validation failed.');
        }

        $vpnServer = $this->getVpnServer();
        $vpnServer->online_counter += 1;
        $vpnServer->save();

        $user = User::where('text_id', '=', $request->input('user_text_id'))->first();

        if (!$user) {
            return $this->fail('User not found.');
        }

        $vpnServerLog = new VpnServerLog();
        $vpnServerLog->vpn_server_id = $vpnServer->id;
        $vpnServerLog->user_id = $user->id;
        $vpnServerLog->type = 'response';
        $vpnServerLog->action = 'client-connect';
        $vpnServerLog->data = json_encode(['ip' => $request->input('ip')]);
        $vpnServerLog->save();

        return $this->ok('Ok');
    }

    public function disconnect(Request $request) {
        $v = Validator::make($request->all(), [
            'ip' => 'required|ip',
            'user_text_id' => 'required|string',
        ]);

        if ($v->fails()) {
            return $this->fail('Validation failed.');
        }

        $vpnServer = $this->getVpnServer();
        if ($vpnServer->online_counter > 0) {
            $vpnServer->online_counter -= 1;
        }
        $vpnServer->save();

        $user = User::where('text_id', '=', $request->input('user_text_id'))->first();

        if (!$user) {
            return $this->fail('User not found.');
        }

        $vpnServerLog = new VpnServerLog();
        $vpnServerLog->vpn_server_id = $vpnServer->id;
        $vpnServerLog->user_id = $user->id;
        $vpnServerLog->type = 'response';
        $vpnServerLog->action = 'client-disconnect';
        $vpnServerLog->data = json_encode(['ip' => $request->input('ip')]);
        $vpnServerLog->save();

        return $this->ok('Ok');
    }

    public function statistics(Request $request) {
        $v = Validator::make($request->all(), [
            'cpu' => 'required|integer',
            'cpu_max' => 'required|integer',
            'ram' => 'required|integer',
            'ram_max' => 'required|integer',
            'hdd' => 'required|integer',
            'hdd_max' => 'required|integer',
        ]);

        if ($v->fails()) {
            return $this->fail('Validation parameters failed');
        }

        $vpnServer = $this->getVpnServer();

        if ($vpnServer->cpu != $request->input('cpu_max')) {
            $vpnServer->cpu = $request->input('cpu_max');
        }

        if ($vpnServer->ram != $request->input('ram_max')) {
            $vpnServer->ram = $request->input('ram_max');
        }

        if ($vpnServer->hdd != $request->input('hdd')) {
            $vpnServer->hdd = $request->input('hdd');
        }

        $vpnServer->save();

        $vpnServerStatistics = new VpnServerStatistics();
        $vpnServerStatistics->vpn_server_id = $vpnServer->id;
        $vpnServerStatistics->cpu = $request->input('cpu');
        $vpnServerStatistics->ram = $request->input('ram');
        $vpnServerStatistics->hdd = $request->input('hdd');
        $vpnServerStatistics->save();

        return $this->ok('Ok');
    }
}
