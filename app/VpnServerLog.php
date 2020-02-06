<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VpnServerLog extends Model
{
    protected $table = 'vpn_servers_log';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            if ($query->type == 'request') {
                $query->event_id = uniqid(Str::random('5'));
            }
        });
    }

    public function vpnServer() {
        return $this->hasOne('App\VpnServer', 'id', 'vpn_server_id');
    }
}
