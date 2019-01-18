<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentScore;

class PaymentsDetailController extends Controller
{
    public function index(Request $request) {
        $paymentScore = PaymentScore::find($request->route('score_id'));

        if (!$paymentScore) {
            return redirect()->back();
        }

        return view('admin.payments_detail')->with([
            'paymentScore' => $paymentScore,
        ]);
    }
}
