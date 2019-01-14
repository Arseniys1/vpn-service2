<?php

namespace App\Api\Payments\Providers;

use Illuminate\Http\Request;
use App\Payment;
use App\PaymentScore;
use App\PaymentProvider;
use App\PaymentStatus;
use App\Access;
use App\UserAccess;
use GuzzleHttp\Client;

class CryptonatorProvider implements IProvider
{
    private $paymentProviderData;
    private $payment;
    private $paymentScore;
    private $paymentProvider;

    private $serviceUrl = 'https://api.cryptonator.com/api/merchant/v1';
    private $serviceInvoiceUrl = 'https://www.cryptonator.com/merchant/invoice';

    public function createPayment(Payment $payment, PaymentScore $paymentScore, PaymentProvider $paymentProvider)
    {
        $this->payment = $payment;
        $this->paymentScore = $paymentScore;
        $this->paymentProvider = $paymentProvider;
        $this->paymentProviderData = json_decode($paymentProvider->data, true);

        if ($this->paymentProviderData == null) {
            $this->setPaymentStatus('internal-error', null, 'Неверная data у payment provider.');

            return view('payments.error')->with([
                'error' => 'Ошибка платежа.'
            ]);
        }

        if ($this->paymentProviderData['type'] == 'createinvoice') {
            $res = $this->createPaymentInvoice();

            if ($res->getStatusCode() == 400) {
                $this->setPaymentStatus('service-error', $res->getBody(), 'Ошибка при создании createinvoice');

                return view('payments.error')->with([
                    'error' => 'Ошибка платежа.'
                ]);
            } elseif ($res->getStatusCode() == 201) {
                $this->setPaymentStatus('created', $res->getBody());

                $resBody = json_decode($res->getBody(), true);

                if (!$this->hashCheck($resBody)) {
                    $this->setPaymentStatus('service-error', $res->getBody(), 'Неверный secret_hash');

                    return view('payments.error')->with([
                        'error' => 'Ошибка платежа.'
                    ]);
                }

                return redirect()->away($this->serviceInvoiceUrl . '/' . $resBody['invoice_id']);
            }
        } else if ($this->paymentProviderData['type'] == 'startpayment') {
            return $this->createPaymentStartPayment();
        }
    }

    private function createPaymentInvoice() {
        $guzzleClient = new Client();

        $formParams = [
            'merchant_id' => $this->paymentProviderData['store_id'],
            'item_name' => $this->paymentScore->access->name_humanity,
            'order_id' => $this->paymentScore->id,
            'item_description' => $this->paymentScore->access->duration_humanity,
            'checkout_currency' => $this->paymentProviderData['checkout_currency'],
            'invoice_amount' => $this->payment->price / 100,
            'invoice_currency' => $this->paymentProviderData['invoice_currency'],
            'success_url' => url('') . $this->paymentProviderData['success_url'],
            'failed_url' => url('') . $this->paymentProviderData['failed_url'],
            'language' => $this->paymentScore->user->locale,
        ];

        $formParams['secret_hash'] = $this->generateHash($formParams);

        $res = $guzzleClient->post($this->serviceUrl . '/createinvoice', [
            'form_params' => $formParams
        ]);

        return $res;
    }

    private function createPaymentStartPayment() {
        $params = [
            'merchant_id' => $this->paymentProviderData['store_id'],
            'item_name' => $this->paymentScore->access->name_humanity,
            'order_id' => $this->paymentScore->id,
            'item_description' => $this->paymentScore->access->duration_humanity,
            'invoice_amount' => $this->payment->price / 100,
            'invoice_currency' => $this->paymentProviderData['invoice_currency'],
            'success_url' => url('') . $this->paymentProviderData['success_url'],
            'failed_url' => url('') . $this->paymentProviderData['failed_url'],
            'language' => $this->paymentScore->user->locale,
        ];

        $params = http_build_query($params);

        return redirect()->away($this->serviceUrl . '/startpayment?' . $params);
    }

    private function generateHash($array) {
        if (is_array($array) && count($array) > 0) {
            $string = implode('&', $array) . '&' . $this->paymentProviderData['store_secret'];
            return sha1($string);
        }
        else {
            return null;
        }
    }

    private function hashCheck($body) {
        $hash = $body['secret_hash'];
        unset($body['secret_hash']);
        if ($hash == sha1(implode('&', $body) . '&' . $this->paymentProviderData['store_secret'])) {
            return $body;
        }
        else {
            return null;
        }
    }

    public function successHandle(Request $request)
    {
        return $this->callbackHandle($request);
    }

    public function errorHandle(Request $request)
    {
        return $this->callbackHandle($request);
    }

    public function notificationHandle(Request $request)
    {
        return $this->callbackHandle($request);
    }

    private function callbackHandle(Request $request) {
        $this->paymentScore = $paymentScore = $this->getPaymentScore($request->input('order_id'));

        if (!$paymentScore) {
            return response('Wrong order_id', 400);
        }

        $this->payment = $payment = $paymentScore->payment;
        $this->paymentProvider = $paymentProvider = $payment->provider;
        $this->paymentProviderData = json_decode($paymentProvider->data, true);

        if (!$this->hashCheck($request->all())) {
            $this->setPaymentStatus('service-error', json_encode($request->all()), 'Неверный secret_hash');

            return response('Wrong secret_hash', 400);
        }

        $this->setPaymentStatus($request->input('invoice_status'), json_encode($request->all()));
        $this->statusHandler($request);

        return response('Success', 200);
    }

    private function statusHandler(Request $request) {
        if ($request->input('invoice_status') == 'paid') {
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
        } else {
            if ($this->payment->user_access_id) {
                $userAccess = UserAccess::where('id', '=', $this->payment->user_access_id)
                    ->first();

                $userAccess->delete();
            }
        }
    }

    public function getServiceName()
    {
        return 'cryptonator.com';
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

    public function getPaymentScore($id) {
        return PaymentScore::where('id', '=', $id)
            ->first();
    }
}