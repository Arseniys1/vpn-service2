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

    public function discount() {
        return $this->hasOne('App\PaymentDiscount', 'id', 'discount_id');
    }
}
