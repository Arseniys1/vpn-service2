<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentScore;
use App\PaymentProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Payment;
use App\Api\Payments\Providers\CryptonatorProvider;
use App\PaymentDiscount;

class WayFormController extends Controller
{
    public function index(Request $request) {
        $paymentScore = PaymentScore::where('id', '=', $request->input('score_id'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('payment_id', '=', null)
            ->first();

        if (!$paymentScore) {
            return view('payments.error')->with([
                'error' => 'Счет на оплату не найден.'
            ]);
        }

        $paymentProvider = PaymentProvider::where('id', '=', $request->input('provider_id'))
            ->first();

        if (!$paymentProvider) {
            return view('payments.error')->with([
                'error' => 'Провайдер не найден.'
            ]);
        }

        return view('payments.way_form')->with([
            'paymentScore' => $paymentScore,
            'paymentProvider' => $paymentProvider,
        ]);
    }

    public function post(Request $request) {
        $v = Validator::make($request->all(), [
            'score_id' => 'required|integer',
            'provider_id' => 'required|integer',
            'discount_code' => 'string|nullable',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        $paymentScore = PaymentScore::where('id', '=', $request->input('score_id'))
            ->where('user_id', '=', Auth::user()->id)
            ->where('payment_id', '=', null)
            ->first();

        if (!$paymentScore) {
            return view('payments.error')->with([
                'error' => 'Счет на оплату не найден.'
            ]);
        }

        $paymentProvider = PaymentProvider::where('id', '=', $request->input('provider_id'))
            ->first();

        if (!$paymentProvider) {
            return view('payments.error')->with([
                'error' => 'Провайдер не найден.'
            ]);
        }

        $paymentDiscount = null;

        if ($request->input('discount_code')) {
            $paymentDiscount = PaymentDiscount::where('code', '=', $request->input('discount_code'))
                ->first();
        }

        $payment = new Payment();
        $payment->score_id = $paymentScore->id;
        $payment->provider_id = $paymentProvider->id;

        if ($paymentDiscount) {
            $payment->discount_id = $paymentDiscount->id;
        }

        $payment->status = 'created';

        if ($paymentDiscount) {
            $pricePercent = $paymentScore->access->price / 100 * ($paymentDiscount->percent / 100);
            $payment->price = $paymentScore->access->price - $pricePercent;
        } else {
            $payment->price = $paymentScore->access->price;
        }

        $payment->save();

        $paymentScore->payment_id = $payment->id;
        $paymentScore->save();

        return $this->handleCreatePayment($payment, $paymentScore, $paymentProvider);
    }

    private function handleCreatePayment($payment, $paymentScore, $paymentProvider) {
        if ($paymentProvider->service_name == 'cryptonator.com') {
            $provider = new CryptonatorProvider();

            return $provider->createPayment($payment, $paymentScore, $paymentProvider);
        }
    }
}
