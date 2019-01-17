<?php

namespace App\Http\Controllers\Payments;

use App\Api\Payments\Providers\RobokassaProvider;
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
        } elseif ($paymentProvider->service_name == 'robokassa.com') {
            $provider = new RobokassaProvider();
        } else {
            return response('Provider not found', 400);
        }

        $methodName = $request->route('method') . 'Handle';

        if (method_exists($provider, $methodName)) {
            return $provider->$methodName($request);
        } else {
            return response('Provider method not found', 400);
        }
    }
}
