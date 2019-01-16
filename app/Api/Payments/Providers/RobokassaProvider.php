<?php

namespace App\Api\Payments\Providers;


use App\Payment;
use App\PaymentProvider;
use App\PaymentScore;
use App\PaymentStatus;
use App\Access;
use App\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class RobokassaProvider implements IProvider
{
    private $paymentProviderData;
    private $payment;
    private $paymentScore;
    private $paymentProvider;

    private $serviceUrl = 'https://auth.robokassa.ru/Merchant/Index.aspx';

    public function createPayment(Payment $payment, PaymentScore $paymentScore, PaymentProvider $paymentProvider)
    {
        $this->payment = $payment;
        $this->paymentScore = $paymentScore;
        $this->paymentProvider = $paymentProvider;
        $this->paymentProviderData = json_decode($paymentProvider->data, true);

        if ($this->paymentProviderData == null) {
            $this->setPaymentStatus('internal-error', null, 'Неверная data у payment provider.');

            return view('payments.way_error')->with([
                'error' => __('payments.payment_error')
            ]);
        }

        return $this->createPaymentLink();
    }

    private function createPaymentLink() {
        $params = [
            "MerchantLogin" => $this->paymentProviderData['MerchantLogin'],
            "OutSum" => $this->payment->price / 100,
            "InvDesc" => __($this->paymentScore->access->name_humanity),
            "InvId" => $this->paymentScore->id,
            "Culture" => $this->paymentScore->user->locale,
            "Encoding" => "utf-8",
            "OutSumCurrency" => "USD",
            "isTest" => true,
        ];

        $params["SignatureValue"] = $this->generateSignatureValue($params);

        $params = http_build_query($params);

        return redirect()->away($this->serviceUrl . '?' . $params);
    }

    private function generateSignatureValue($params) {
        $string = sha1(
            $params['MerchantLogin'] . ':' .
            $params['OutSum'] . ':' .
            $params['InvId'] . ':' .
            $params['OutSumCurrency'] . ':' .
            $this->paymentProviderData['MerchantPassword1']
        );

        return $string;
    }

    private function checkSignatureValue($array) {
        $string = $array['OutSum'] . ':' . $array['InvId'] . ':' . $this->paymentProviderData['MerchantPassword2'];
        $string = sha1($string);

        if ($string == $array['SignatureValue']) {
            return true;
        }

        return false;
    }

    public function notificationHandle(Request $request)
    {
        $this->paymentScore = $paymentScore = PaymentScore::where('id', '=', $request->input('InvId'))
            ->first();

        if (!$paymentScore) {
            return response('Wrong InvId', 400);
        }

        $this->payment = $payment = $paymentScore->payment;
        $this->paymentProvider = $paymentProvider = $payment->provider;
        $this->paymentProviderData = json_decode($paymentProvider->data, true);

        if (!$this->checkSignatureValue($request->all())) {
            $this->setPaymentStatus('service-error', json_encode($request->all()), 'Неверный SignatureValue');

            return response('Wrong SignatureValue', 400);
        }

        $this->setPaymentStatus('paid', json_encode($request->all()));
        $this->statusHandler();

        return response('OK' . $request->input('InvId'));
    }

    private function statusHandler() {
        if ($this->payment->user_access_id == null) {
            $access = Access::where('id', '=', $this->paymentScore->access_id)
                ->first();

            $userAccess = new UserAccess();
            $userAccess->user_id = $this->paymentScore->user_id;
            $userAccess->access_id = $access->id;
            $userAccess->end_at = time() + $access->duration;
            $userAccess->save();

            $this->payment->user_access_id = $userAccess->id;
            $this->payment->save();
        }
    }

    public function successHandle(Request $request)
    {
        $parameters = [
            'locale' => App::getLocale(),
        ];

        if ($request->has('InvId')) {
            $parameters['score_id'] = $request->input('InvId');
        }

        return redirect()->route('payments.success', $parameters);
    }

    public function errorHandle(Request $request)
    {
        $parameters = [
            'locale' => App::getLocale(),
        ];

        if ($request->has('InvId')) {
            $parameters['score_id'] = $request->input('InvId');
        }

        return redirect()->route('payments.error', $parameters);
    }

    public function setPaymentStatus($status = 'internal-error', $data = null, $comment = null)
    {
        $this->payment->status = $status;
        $this->payment->save();

        $paymentStatus = new PaymentStatus();
        $paymentStatus->payment_id = $this->payment->id;
        $paymentStatus->status = $status;
        $paymentStatus->data = $data;
        $paymentStatus->comment = $comment;
        $paymentStatus->save();
    }
}