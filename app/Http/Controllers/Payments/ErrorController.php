<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentScore;
use Illuminate\Support\Facades\Auth;

class ErrorController extends Controller
{
    public function index(Request $request) {
        $paymentScore = null;

        if ($request->has('score_id')) {
            $paymentScore = PaymentScore::where('id', '=', $request->input('score_id'))
                ->where('user_id', '=', Auth::user()->id)
                ->first();
        }

        return view('payments.error')->with([
            'paymentScore' => $paymentScore,
        ]);
    }
}
