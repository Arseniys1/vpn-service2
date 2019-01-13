<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    public function score() {
        return $this->hasOne('App\PaymentScore', 'id', 'score_id');
    }

    public function provider() {
        return $this->hasOne('App\PaymentProvider', 'id', 'provider_id');
    }

    public function statuses() {
        return $this->hasMany('App\PaymentStatus', 'payment_id', 'id');
    }

    public function discount() {
        return $this->hasOne('App\PaymentDiscount', 'id', 'discount_id');
    }

    public function userAccess() {
        return $this->hasOne('App\UserAccess', 'id', 'user_access_id');
    }
}
