<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Payment;
use App\PaymentScore;
use App\PaymentProvider;
use App\Api\Payments\Providers\CryptonatorProvider;

class CryptonatorProviderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $payment = $this->getPayment();
        $paymentScore = $this->getPaymentScore();
        $paymentProvider = $this->getPaymentProvider();

        $provider = new CryptonatorProvider();

        $result = $provider->createPayment($payment, $paymentScore, $paymentProvider);
    }

    private function getPayment() {
        return Payment::first();
    }

    private function getPaymentScore() {
        return PaymentScore::first();
    }

    private function getPaymentProvider() {
        return PaymentProvider::first();
    }
}
