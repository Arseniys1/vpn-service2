<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VpnServerAccess extends Model
{
    protected $table = 'vpn_servers_access';

    public function log() {
        $this->hasOne('App/VpnServerLog', 'id', 'vpn_servers_log_id');
    }

    public function vpnServer() {
        $this->hasOne('App/VpnServer', 'id', 'vpn_server_id');
    }

    public function user() {
        $this->hasOne('App/User', 'id', 'user_id');
    }
}
