<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentScore;
use Illuminate\Support\Facades\Auth;
use App\PaymentProvider;

class WayController extends Controller
{
    public function index(Request $request) {
        $paymentScore = PaymentScore::where('id', '=', $request->input('score_id'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('payment_id', '=', null)
            ->first();

        if (!$paymentScore) {
            return view('payments.error')->with([
                'error' => __('payments.error_payment_invoice_not_found')
            ]);
        }

        return view('payments.way')->with([
            'providers' => $this->getProviders(),
            'score' => $paymentScore,
        ]);
    }

    private function getProviders() {
        return PaymentProvider::get();
    }
}
