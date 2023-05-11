<?php

namespace App\Http\Controllers;

use App\Client;
use App\Helpers\SmsHelper;
use App\Invoice;
use App\Mail\OnlinePaymentSuccessReceipt;
use App\OnlineNewApplicationRequest;
use App\OnlinePayment;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRequest;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleHttpClient;

class OnlinePaymentController extends Controller
{
    /**
     * This is the receive point for the email payment link
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
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

        // block if payment request status is either failed or completed
        if (in_array($paymentRequest->status, ['failed', 'completed'])) {
            abort(400, 'Invalid request. Payment attempt denied.');
        }

        // required params
        $requestUrl = config('ipg.mode') == 'production' ? config('ipg.url') : config('ipg.testing_url');
        $merchantId = config('ipg.merchant_id');
        $orderId = uniqid('peanwp_', true);
        $apiPassword = config('ipg.integration_auth_password');

        // Create a client with a base URI
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        $client = new GuzzleHttpClient(['base_uri' => $requestUrl, 'headers' => $headers]);
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
        // dd($stringBody);
        // if result is not success
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

    /**
     * Send payment complete SMS and Email
     *
     * @param OnlinePayment $onlinePayment
     * @return void
     */
    public function sendPaymentCompleteSMS(OnlinePayment $onlinePayment)
    {
        $application = $onlinePayment->onlineRequest->applicationRequest();
        $client = $application->client;
        // create person name from salutation, firstname, and lastname
        $personName = sprintf('%s %s %s', $client->name_title, $client->first_name, $client->last_name);
        $businessName = $client->industry_name;

        //get invoice
        $invoice = Invoice::where('online_payment_id', $onlinePayment->id)->first();

        // get email and mobile number from request entries
        if (get_class($application) === "App\\OnlineNewApplicationRequest") {
            // get from new application request entry
            $requestType = OnlineRequest::NEW;
            $emailAddress = $application->email_address;
            $mobileNumber = $application->mobile_number;
        } elseif (get_class($application) === "App\\OnlineRenewalApplicationRequest") {
            // get from renewal application request entry
            $requestType = OnlineRequest::RENEWAL;
            $emailAddress = $application->email;
            $mobileNumber = $application->mobile_no;
        } elseif (get_class($application) === "App\\Transaction") {
            // get from transaction
            $requestType = OnlineRequest::PAYMENT;
            $client = $application->client;
            $emailAddress = $client->email;
            $mobileNumber = $client->contact_no;
        }

        // check for mobile number existance and send SMS
        if (!empty($mobileNumber)) {
            $famt = number_format($onlinePayment->amount, 2);
            $refNo = $onlinePayment->reference_no;
            $message = "Hello,\nThank you for your payment of {$famt}. Invoice No:{$invoice->invoice_number}\nEnvironment Authority NWP";

            // send message
            $isSent = SmsHelper::sendSms($mobileNumber, $message);
        }

        if (!empty($emailAddress)) {
            // send payment receipt email
            $successMail = new OnlinePaymentSuccessReceipt(
                $requestType,
                $businessName,
                $personName,
                $client,
                $application,
                number_format($onlinePayment->amount, 2),
                $refNo
            );
            // send email
            Mail::to($emailAddress)->send($successMail);
        }
    }

    /**
     * Receive IPG payment SUCCESS result
     *
     * @param Request $request
     * @param OnlinePayment $paymentRequest
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
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

            $onlineRequest = $onlinePayment->onlineRequest;
            $onlineRequest->status = 'complete';
            $onlineRequest->save();

            //invoice code
            // $year = Carbon::now()->format('Y');
            $number = 1;

            $lastInvoiceNumber = Invoice::select('invoice_number')
                ->orderBy('created_at', 'desc')
                ->withTrashed()
                ->first();

            if ($lastInvoiceNumber) {
                $number = $lastInvoiceNumber->invoice_number + 1;
                $invoiceNo =  $number;
            }

            $invoiceNo = $number;

            // complete payment status for request_id
            if ($onlineRequest->request_type == OnlineRequest::RENEWAL) {
                $model = OnlineRenewalApplicationRequest::whereId($onlineRequest->online_request_id)->first();
                $model->status = 'complete';
                $model->save();
                $onlineRequest = OnlineRequest::where('id', $onlinePayment->online_request_id)->select('online_request_id')->first();
                $onlineRequestData = OnlineRenewalApplicationRequest::where('id', $onlineRequest->online_request_id)->select('industry_name', 'mobile_no', 'nic_number')->first();
                //generate invoice
                $invoice = Invoice::create([
                    'name' => $onlineRequestData->industry_name,
                    'contact' => $onlineRequestData->mobile_no,
                    'nic' => $onlineRequestData->nic_number,
                    'invoice_number' => $invoiceNo,
                    'payment_method' => 'online',
                    'amount' => $onlinePayment->amount,
                    'sub_total' => $onlinePayment->amount,
                    'invoice_date' => Carbon::now()->format('Y-m-d'),
                    'online_payment_id' => $onlinePayment->id,
                ]);

                $transaction = Transaction::where('online_payment_id', $onlinePayment->id)->first();
                $transaction->invoice_id = $invoice->id;
                $transaction->invoice_no = $invoice->invoice_number;
                $transaction->status = 1;
                $transaction->save();
            } elseif ($onlineRequest->request_type == OnlineRequest::NEW) {
                $model = OnlineNewApplicationRequest::whereId($onlineRequest->online_request_id)->first();
                $model->status = 'complete';
                $model->save();
                $invoice = Invoice::create([
                    'name' => $model->business_name,
                    'contact' => $model->mobile_number,
                    'nic' => $model->nic_number,
                    'invoice_number' => $invoiceNo,
                    'payment_method' => 'online',
                    'amount' => $onlinePayment->amount,
                    'sub_total' => $onlinePayment->amount,
                    'invoice_date' => Carbon::now()->format('Y-m-d'),
                    'online_payment_id' => $onlinePayment->id,
                ]);

                $transaction = Transaction::where('online_payment_id', $onlinePayment->id)->first();
                $transaction->invoice_id = $invoice->id;
                $transaction->invoice_no = $invoice->invoice_number;
                $transaction->status = 1;
                $transaction->save();
            } elseif ($onlineRequest->request_type == OnlineRequest::PAYMENT) {
                $model = Transaction::whereId($onlineRequest->request_id)->first();
                $model->status = '1'; // set in transaction
                $model->invoice_no = $invoiceNo;
                $model->save();
                $client = Client::whereId($model->client_id)->select('industry_name', 'industry_address', 'contact_no', 'nic')->first();
                $invoice = Invoice::create([
                    'name' => $client->industry_name,
                    'contact' => $client->contact_no,
                    'nic' => $client->nic,
                    'address' => $client->industry_address,
                    'invoice_number' => $invoiceNo,
                    'payment_method' => 'online',
                    'amount' => $onlinePayment->amount,
                    'sub_total' => $onlinePayment->amount,
                    'invoice_date' => Carbon::now()->format('Y-m-d'),
                    'online_payment_id' => $onlinePayment->id,
                ]);
                $model->invoice_id = $invoice->id;
                $model->invoice_no = $invoice->invoice_number;
                $model->status = 1;
                $model->save();
            }
            // send SMS
            $this->sendPaymentCompleteSMS($onlinePayment);
        } else {
            // payment failed.
            $onlinePayment->status = 'failed';
            $view = 'online-requests.results.failed';
        }
        $onlinePayment->save();


        return view($view, ['paymentRequest' => $onlinePayment]);
    }

    /**
     * Receive IPG payment cancelled result
     *
     * @param Request $request
     * @param OnlinePayment $paymentRequest
     * @return void
     */
    public function receivePaymentCancelled(Request $request, OnlinePayment $paymentRequest)
    {
        // update payment request status to cancelled
        $paymentRequest->status = 'cancelled';
        $paymentRequest->save();

        return view('online-requests.results.cancelled', compact('paymentRequest'));
    }

    /**
     * Generate receipt for payment request
     *
     * @param OnlinePayment $paymentRequest
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function generateReceipt(OnlinePayment $paymentRequest)
    {
        $application = $paymentRequest->onlineRequest->applicationRequest();
        $client = $application->client;
        $personName = sprintf('%s %s %s', $client->name_title, $client->first_name, $client->last_name);
        $businessName = $client->industry_name;
        $invoice = Invoice::where('online_payment_id', $paymentRequest->id)->first();

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
                'mobileNumber',
                'invoice'
            )
        );
    }

    /**
     * Show page to create an online payment request for the transaction
     *
     * @param Transaction $transaction
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
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

    public function onlineTreeFellingRequests()
    {
        return view('online-requests.tree-felling-request');
    }
}
