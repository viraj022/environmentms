<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Client;
use App\Mail\OnlineApplicationPaymentLink;
use App\OnlineNewApplicationRequest;
use App\OnlinePayment;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRequest;
use App\OnlineRequestStatus;
use App\Repositories\OnlineRequestRepository;
use App\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use OCILob;

class OnlineRequestController extends Controller
{
    private $onlineRequests;
    public function __construct(OnlineRequestRepository $onlineRequestRepository)
    {
        $this->middleware('auth');
        $this->onlineRequests = $onlineRequestRepository;
    }

    public function viewRenewalAttachmentFile(OnlineRenewalApplicationRequest $renewal)
    {
        $baseUrl = config('online-request.url');
        $fileName = basename($renewal->attachment_file);

        $url = sprintf('%s/storage/renewal-attachments/%s', $baseUrl, $fileName);
        return redirect($url);
    }

    /**
     * Show a page with all online requests received
     * and their current status as a list
     *
     * @return void
     */
    public function index()
    {
        $businessScales = [
            '1' => 'Small - S',
            '2' => 'Medium - M',
            '3' => 'Large - L',
        ];

        $renewalApplications = $this->onlineRequests->getAllRenewalApplications();
        $newApplications = $this->onlineRequests->getAllNewApplications();

        return view(
            'online-requests.index',
            compact('renewalApplications', 'newApplications', 'businessScales')
        );
    }

    /**
     * Show all renewal requests page
     *
     * @param OnlineRenewalApplicationRequest $renewal
     * @return Collection
     */
    public function viewRenewalRequest(OnlineRenewalApplicationRequest $renewal)
    {
        $client = null;
        $certificate = $this->onlineRequests->getCertificateByCertificateNumber($renewal->certificate_number);
        if ($certificate) {
            $client = $certificate->client;
        }

        return view(
            'online-requests.renewal-view',
            compact('renewal', 'client')
        );
    }

    public function getClientByOldFileNumber(Request $request)
    {
        $file_no = $request->post('file_no');
        $fileNo = $this->onlineRequests->getClientByFileNumber($file_no);

        return response()->json(['data' => $fileNo]);
    }

    /**
     * Make changes to the renewal request with the data sent in the request
     *
     * @param Request $request
     * @param OnlineRenewalApplicationRequest $renewal
     * @return RedirectResponse
     */
    public function updateRenewalRequest(Request $request, OnlineRenewalApplicationRequest $renewal)
    {
        $requestData = $request->all();

        $validated = $request->validate([
            'renewal_client_id' => 'required|exists:clients,id',
            'renewal_renewal_id' => 'required|exists:online_renewal_application_requests,id',
            'renewal_update_certificate_number' => 'nullable|exists:certificates,cetificate_number',
        ], $requestData);

        // check if client is legit
        $client = $this->onlineRequests->getClientById($validated['renewal_client_id']);
        if (empty($client)) {
            return redirect()->route('online-requests.renewal.view', $renewal)
                ->with('error', 'Cannot identify the client by the given id. Please try again later.');
        }

        // check if the client id matches the certificate number
        $cert = $this->onlineRequests->getCertificateByClientIdAndCertificateNumber(
            $client->id,
            $validated['renewal_update_certificate_number']
        );
        if (empty($cert)) {
            return redirect()->route('online-requests.renewal.view', $renewal)
                ->with('error', 'Cannot verify the certificate number you entered 
                for the selected client. Please try again.');
        }

        // make changes to the certificate number
        $renewal->person_name = sprintf('%s %s %s', $client->name_title, $client->first_name, $client->last_name);
        $renewal->industry_name = $client->industry_name;
        $renewal->business_registration_no = $client->industry_registration_no;
        $renewal->certificate_number = $cert->cetificate_number;
        $renewal->client_id = $client->id;
        $renewal->status = 'accepted'; // changed to accepted from acceptance_pending
        $renewal->save();

        // create status updated record
        $onlineRequestStatus = $this->onlineRequests->createOnlineRequestStatus([
            'online_request_id' => $renewal->id,
            'status' => 'accepted',
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('online-requests.renewal.view', $renewal)
            ->with('success', 'Renewal request accepted successfully.');
    }

    public function sendPaymentLink(Request $request, OnlineRequest $onlineRequest)
    {
        $data = $request->validate([
            'payment_amount' => 'required|numeric'
        ], $request->all());

        $paymentAmount = doubleval($data['payment_amount']);
        $application = $onlineRequest->applicationRequest();
        $client = $application->client;
        $personName = sprintf('%s %s %s', $client->name_title, $client->first_name, $client->last_name);
        $businessName = $client->industry_name;

        if (get_class($application) === "App\\OnlineNewApplicationRequest") {
            $requestType = OnlineRequest::NEW;
            $emailAddress = $application->email_address;
            $mobileNumber = $application->mobile_number;
        } elseif (get_class($application) === 'App\\OnlineRenewalApplicationRequest') {
            $requestType = OnlineRequest::RENEWAL;
            $emailAddress = $application->email;
            $mobileNumber = $application->mobile_no;
        } elseif (get_class($application) === 'App\\Transaction') {
            $requestType = OnlineRequest::PAYMENT;
            $emailAddress = $application->client->email;
            $mobileNumber = $application->client->mobile_no;
        }

        // create online payment record
        $onp = OnlinePayment::create([
            'online_request_id' => $onlineRequest->id,
            'reference_no' => Str::uuid()->toString(),
            'amount' => $paymentAmount,
        ]);

        // generate a signed URL
        $paymentLink = URL::temporarySignedRoute(
            'online-request.pay',
            now()->addWeek(),
            ['id' => $onlineRequest->id, 'pid' => $onp->id]
        );

        // for testing purposes
        if (config('app.env') == 'local') {
            $emailAddress = 'test@ceytech.lk';
            $mobileNumber = '0712912826';
        }

        if (!empty($emailAddress)) {
            // send email
            $linkEmail = new OnlineApplicationPaymentLink(
                $paymentLink,
                $requestType,
                $businessName,
                $personName,
                $client,
                $application,
                number_format($paymentAmount, 2),
            );
            $response = Mail::to($emailAddress)
                ->send($linkEmail);
        }

        if (!empty($mobileNumber)) {
            // send POST request with header key
            $sms_message = "Hello,\nPlease follow the link to make your payment. ${paymentLink}\nEnvironment Authority NWP";
            $sms_number = preg_replace('/^\+?1|\|1|\D/', '', $mobileNumber);
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

        // set return route
        $returnId = $onlineRequest->request_id;
        if ($requestType == OnlineRequest::RENEWAL) {
            $routeName = 'online-requests.renewal.view';
        } elseif ($requestType == OnlineRequest::NEW) {
            $routeName = 'online-requests.new-application.view';
        } elseif ($requestType == OnlineRequest::PAYMENT) {
            $returnId = $client->id;
            $routeName = 'industry_profile.find';
        }

        // send to the route with message
        return redirect()->route($routeName, $returnId)
            ->with('success', 'Payment created and payment links sent successfully.');
    }

    /**
     * Show details of a new application request sent from the online requests portal
     *
     * @param OnlineNewApplicationRequest $request
     * @return void
     */
    public function viewNewApplicationRequest(OnlineNewApplicationRequest $newApplication)
    {
        $businessScales = [
            '1' => 'Small - S',
            '2' => 'Medium - M',
            '3' => 'Large - L',
        ];

        return view(
            'online-requests.new-application-view',
            compact('newApplication', 'businessScales')
        );
    }

    public function registerAndSendOnlinePaymentLinksForTransaction(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_amount' => 'required|numeric',
        ], $request->all());

        $transactionStatuses = [
            0 => 'Unpaid', 1 => 'Paid', 2 => 'Processed', 3 => 'Cancelled'
        ];
        $transaction = Transaction::whereId($validated['transaction_id'])
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

        $onlineRequest = OnlineRequest::create([
            'request_type' => 'payment', 'status' => 'pending', 'request_id' => $transaction->id,
            'request_model' => Transaction::class,
        ]);

        return $this->sendPaymentLink($request, $onlineRequest);
    }
}
