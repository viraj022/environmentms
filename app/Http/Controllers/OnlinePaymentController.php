<?php

namespace App\Http\Controllers;

use App\Mail\OnlinePaymentSuccessReceipt;
use App\OnlineNewApplicationRequest;
use App\OnlinePayment;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRequest;
use App\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class OnlinePaymentController extends Controller
{
    /**
     * This is the receive point for the email payment link
     *
     * @param Request $request
     * @return void
     */
    public function receiveRenewalPaymentLink(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(400, 'Invalid request. Request rejected.');
        }

        // recieve data
        $id = $request->get('id');
        $pid = $request->get('pid');
        $onlineRequest = OnlineRequest::find($id);
        $paymentRequest = OnlinePayment::find($pid);

        if (in_array($paymentRequest->status, ['failed', 'completed'])) {
            abort(400, 'Invalid request. Payment attempt denied.');
        }

        // required params
        $requestUrl = 'https://test-bankofceylon.mtf.gateway.mastercard.com';
        $merchantId = config('ipg.merchant_id');
        $orderId = uniqid('peanwp_', true);
        $apiPassword = config('ipg.integration_auth_password');

        // Create a client with a base URI
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $client = new Client(['base_uri' => $requestUrl, 'headers' => $headers]);
        // send POST request to version 60 API
        $response = $client->post('/api/nvp/version/60', [
            'form_params' => [
                'apiUsername' => 'merchant.' . $merchantId,
                'apiPassword' => $apiPassword,
                'apiOperation' => 'CREATE_CHECKOUT_SESSION',
                'interaction.operation' => 'PURCHASE',
                'merchant' => $merchantId,
                'order.id' => $paymentRequest->reference_no,
                'order.currency' => 'LKR',
                'order.amount' => $paymentRequest->amount,
                'interaction.returnUrl' => route('payment-result.return', $paymentRequest->id),
                'interaction.cancelUrl' => route('payment-result.cancelled', $paymentRequest->id),
            ]
        ]);

        // get the body cast to string type
        $stringBody = (string) $response->getBody();
        parse_str($stringBody, $initParams); // parse the received query string to an array

        // in result is not success
        if ($initParams['result'] !== 'SUCCESS') {
            // abort the payment request.
            abort('401', 'Failed to authorize the payment.');
        }

        // store success indicator
        $paymentRequest->ipg_success_indicator = $initParams['successIndicator'];
        $paymentRequest->save();

        // send to the redirection page with session data
        return view('online-requests.gateway-redirect', compact('initParams', 'onlineRequest', 'paymentRequest', 'orderId'));
    }

    public function sendPaymentCompleteSMS(OnlinePayment $onlinePayment)
    {
        $application = $onlinePayment->onlineRequest->applicationRequest();
        $client = $application->client;
        $personName = sprintf('%s %s %s', $client->name_title, $client->first_name, $client->last_name);
        $businessName = $client->industry_name;

        if (get_class($application) === "App\\OnlineNewApplicationRequest") {
            $requestType = OnlineRequest::NEW;
            $emailAddress = $application->email_address;
            // $emailName = sprintf('%s %s %s', $application->title, $application->firstname, $application->lastname);
            $mobileNumber = $application->mobile_number;
        } elseif (get_class($application) === "App\\OnlineRenewalApplicationRequest") {
            $requestType = OnlineRequest::RENEWAL;
            $emailAddress = $application->email;
            // $emailName = $application->person_name;
            $mobileNumber = $application->mobile_no;
        } elseif (get_class($application) === "App\\Transaction") {
            $requestType = OnlineRequest::PAYMENT;
            $client = $application->client;
            $emailAddress = $client->email;
            // $emailName = $application->person_name;
            $mobileNumber = $client->contact_no;
        }

        if (!empty($mobileNumber)) {
            // send POST request with header key
            $famt = number_format($onlinePayment->amount, 2);
            $refNo = $onlinePayment->reference_no;
            $sms_message = "Hello,\nThank you for your payment of {$famt}. Ref:{$refNo}\nEnvironment Authority NWP";
            $sms_number = preg_replace('/^\+?1|\|1|\D/', '', $mobileNumber);
            $sms_number = '0712912826';
            $data = array(
                'SmsMessage' => $sms_message,
                'PhoneNumber' => $sms_number,
                'CompanyId' => 'CEYTECHAPI394',
                'Pword' => 'aQyp7glqK0',
            );

            $json_data = json_encode($data);
            $ch = curl_init('http://smsm.lankabell.com:4040/Sms.svc/PostSendSms');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $smsResult = json_decode($result);
            if ($smsResult->Status != "200") {
                logger('failed to send SMS to ' . $sms_number);
            } else {
                logger('SMS sent to ' . $sms_number);
            }
        }

        if (!empty($emailAddress)) {
            // send payment receipt email
            // send email
            $successMail = new OnlinePaymentSuccessReceipt(
                $requestType,
                $businessName,
                $personName,
                $client,
                $application,
                number_format($onlinePayment->amount, 2),
                $refNo
            );
            Mail::to($emailAddress)->send($successMail);
        }
    }

    /**
     * This is the return URL from the IPG with the payment result
     *
     * @param Request $request
     * @param OnlinePayment $paymentRequest
     * @return void
     */
    public function receivePaymentReturn(Request $request, OnlinePayment $onlinePayment)
    {
        $resultIndicator = $request->get('resultIndicator');
        $ipgSuccessIndicator = $onlinePayment->ipg_success_indicator;

        $onlinePayment->ipg_result_indicator = $resultIndicator;
        if ($resultIndicator == $ipgSuccessIndicator) {
            // this is a successfully completed payment attempt.
            $onlinePayment->status = 'completed';
            $onlinePayment->paid_at = now();
            $view = 'online-requests.results.success';

            // send SMS
            $this->sendPaymentCompleteSMS($onlinePayment);
        } else {
            // payment failed.
            $onlinePayment->status = 'failed';
            $view = 'online-requests.results.failed';
        }
        $onlinePayment->save();
        $onlineRequest = $onlinePayment->onlineRequest;
        $onlineRequest->status = 'complete';
        $onlineRequest->save();

        // complete payment status for request_id
        if ($onlineRequest->request_type == OnlineRequest::RENEWAL) {
            $model = OnlineRenewalApplicationRequest::whereId($onlineRequest->request_id)->first();
            $model->status = 'complete';
            $model->save();
        } elseif ($onlineRequest->request_type == OnlineRequest::NEW) {
            $model = OnlineNewApplicationRequest::whereId($onlineRequest->request_id)->first();
            $model->status = 'complete';
            $model->save();
        } elseif ($onlineRequest->request_type == OnlineRequest::PAYMENT) {
            $model = Transaction::whereId($onlineRequest->request_id)->first();
            $model->status = '1'; // set in transaction
            $model->save();
        }

        return view($view, ['paymentRequest' => $onlinePayment]);
    }

    public function receivePaymentCancelled(Request $request, OnlinePayment $paymentRequest)
    {
        $paymentRequest->status = 'cancelled';
        $paymentRequest->save();
        return view('online-requests.results.cancelled', compact('paymentRequest'));
    }

    public function generateReceipt(OnlinePayment $paymentRequest)
    {
        $application = $paymentRequest->onlineRequest->applicationRequest();
        $client = $application->client;
        $personName = sprintf('%s %s %s', $client->name_title, $client->first_name, $client->last_name);
        $businessName = $client->industry_name;

        if (get_class($application) === "App\\OnlineNewApplicationRequest") {
            $requestType = OnlineRequest::NEW;
            $emailAddress = $application->email_address;
            $mobileNumber = $application->mobile_number;
        } elseif (get_class($application) === "App\\OnlineRenewalApplicationRequest") {
            $requestType = OnlineRequest::RENEWAL;
            $emailAddress = $application->email;
            $mobileNumber = $application->mobile_no;
        } elseif (get_class($application) === "App\\Transaction") {
            $requestType = OnlineRequest::PAYMENT;
            $client = $application->client;
            $emailAddress = $application->email;
            $mobileNumber = $application->contact_no;
        }

        return view(
            'online-requests.printable.payment-receipt',
            compact(
                'paymentRequest',
                'application',
                'client',
                'personName',
                'businessName',
                'requestType',
                'emailAddress',
                'mobileNumber'
            )
        );
    }

    /**
     * Show page to create an online payment request for the transaction
     *
     * @param Transaction $transaction
     * @return void
     */
    public function createForTransaction(Transaction $transaction)
    {
        $transactionStatuses = [
            0 => 'Unpaid', 1 => 'Paid', 2 => 'Processed', 3 => 'Cancelled'
        ];
        $transaction = Transaction::whereId($transaction->id)
            ->with(
                'client',
                'client.industryCategory',
                'client.businessScale',
                'client.pradesheeyasaba',
                'transactionItems',
                'transactionItems.payment',
                'transactionItems.paymentType'
            )
            ->first();
        $client = $transaction->client;
        return view(
            'transactions-online-payments.create-request',
            compact('transaction', 'transactionStatuses', 'client')
        );
    }
}
