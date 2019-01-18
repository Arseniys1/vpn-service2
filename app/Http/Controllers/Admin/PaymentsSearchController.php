<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentScore;
use Illuminate\Support\Facades\Validator;

class PaymentsSearchController extends Controller
{
    public function index(Request $request) {
        $v = Validator::make($request->all(), [
            'searchFor' => 'required|string|in:id,user_id,user_name,access_id,payment_id',
            'searchValue' => 'required|string',
        ]);

        if ($v->fails()) {
            return redirect()->back();
        }

        $paymentsScore = null;

        if ($request->input('searchFor') == 'id') {
            $paymentsScore = PaymentScore::where('id', '=', $request->input('searchValue'))->simplePaginate(15);
        } elseif ($request->input('searchFor') == 'user_id') {
            $paymentsScore = PaymentScore::where('user_id', '=', $request->input('searchValue'))->simplePaginate(15);
        } elseif ($request->input('searchFor') == 'user_name') {
            $paymentsScore = PaymentScore::whereHas('user', function ($query) use ($request) {
                $query->where('name', '=', $request->input('searchValue'));
            })->simplePaginate(15);
        } elseif ($request->input('searchFor') == 'access_id') {
            $paymentsScore = PaymentScore::where('access_id', '=', $request->input('searchValue'))->simplePaginate(15);
        } elseif ($request->input('searchFor') == 'payment_id') {
            $paymentsScore = PaymentScore::where('payment_id', '=', $request->input('searchValue'))->simplePaginate(15);
        }

        return view('admin.payments')->with([
            'paymentsScore' => $paymentsScore,
            'backButton' => true,
        ]);
    }
}
