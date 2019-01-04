<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VpnServer extends Model
{
    protected $table = 'vpn_servers';

    public function country() {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }
}
