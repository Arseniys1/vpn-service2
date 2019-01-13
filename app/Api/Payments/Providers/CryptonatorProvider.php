<?php

namespace App\Api\Payments\Providers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentScore;
use App\PaymentProvider;
use GuzzleHttp\Client;

class CryptonatorProvider implements IProvider
{
    private $paymentProviderData;

    public function createPayment(Payment $payment, PaymentScore $paymentScore, PaymentProvider $paymentProvider)
    {
        $this->paymentProviderData = json_decode($paymentProvider->data, true);

        $guzzleClient = new Client();

        //$res = $guzzleClient->post('');
    }

    public function successHandle(Request $request)
    {

    }

    public function errorHandle(Request $request)
    {

    }

    public function getServiceName()
    {
        return 'cryptonator.com';
    }

}