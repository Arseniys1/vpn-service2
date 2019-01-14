<?php

namespace App\Http\Controllers\Payments;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentProvider;
use App\Api\Payments\Providers\CryptonatorProvider;

class CallbackHunterController extends Controller
{
    public function serviceCallback(Request $request) {
        $paymentProvider = PaymentProvider::where('service_name_slug', '=', $request->route('service_slug'))
            ->first();

        if (!$paymentProvider) {
            return response('Provider not found', 400);
        }

        $provider = null;

        if ($paymentProvider->service_name == 'cryptonator.com') {
            $provider = new CryptonatorProvider();
        } else {
            return response('Provider not found', 400);
        }

        return $provider->notificationHandle($request);
    }
}
