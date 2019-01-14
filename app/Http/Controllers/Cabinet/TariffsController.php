<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Access;
use App\PaymentScore;
use Illuminate\Support\Facades\Auth;

class TariffsController extends Controller
{
    public function index(Request $request) {
        $access = Access::get();

        return view('cabinet.cab_tariffs')->with([
            'tariffs' => $access,
        ]);
    }

    public function createPaymentScore(Request $request) {
        $access = Access::find($request->route('access_id'));

        if (!$access) {
            return redirect()->back();
        }

        $paymentScore = PaymentScore::where('user_id', '=', Auth::user()->id)
            ->where('access_id', '=', $access->id)
            ->where('payment_id', '=', null)
            ->first();

        if (!$paymentScore) {
            $paymentScore = new PaymentScore();
            $paymentScore->user_id = Auth::user()->id;
            $paymentScore->access_id = $access->id;
            $paymentScore->save();
        }

        return redirect()->route('payments.way', ['score_id' => $paymentScore->id]);
    }
}
