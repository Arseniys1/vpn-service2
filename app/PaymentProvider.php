<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentProvider extends Model
{
    protected $table = 'payments_provider';

    public function ips() {
        return $this->hasMany('App\PaymentProviderIp', 'provider_id', 'id');
    }
}
