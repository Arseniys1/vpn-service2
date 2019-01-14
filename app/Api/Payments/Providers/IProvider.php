<?php

namespace App\Api\Payments\Providers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentScore;
use App\PaymentProvider;

interface IProvider
{
    public function createPayment(Payment $payment, PaymentScore $paymentScore, PaymentProvider $paymentProvider);
    public function notificationHandle(Request $request);
}