<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\VpnServerAccess;

class VpnServer extends Model
{
    protected $table = 'vpn_servers';

    protected $hidden = [
        'country_id',
        'vps_username',
        'vps_password',
        'token',
        'ovpn_config',
    ];

    public function country() {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

    public function getHaveAccessAttribute() {
        if (!Auth::check()) return $this->attributes['have_access'] = false;

        $vpnServerAccess = VpnServerAccess::where('vpn_server_id', '=', $this->id)
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'open')
            ->first();

        if (!$vpnServerAccess) {
            return $this->attributes['have_access'] = false;
        }

        return $this->attributes['have_access'] = true;
    }
}
