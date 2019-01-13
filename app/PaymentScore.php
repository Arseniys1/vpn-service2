<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentScore extends Model
{
    protected $table = 'payments_score';

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function access() {
        return $this->hasOne('App\Access', 'id', 'access_id');
    }

    public function payment() {
        return $this->hasOne('App\Payment', 'id', 'payment_id');
    }
}
