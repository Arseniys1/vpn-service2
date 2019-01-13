<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $table = 'payments_status';

    public function payment() {
        return $this->hasOne('App\Payment', 'id', 'payment_id');
    }
}
