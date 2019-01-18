<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentScore;

class PaymentsController extends Controller
{
    public function index(Request $request) {
        $paymentsScore = PaymentScore::simplePaginate(15);

        return view('admin.payments')->with([
            'paymentsScore' => $paymentsScore
        ]);
    }
}
