<?php

namespace App\Http\Controllers;

use App\Helpers\SmsHelper;
use App\Mail\OnlineApplicationPaymentLink;
use App\OnlineNewApplicationRequest;
use App\OnlinePayment;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRequest;
use App\Repositories\OnlineRequestRepository;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OnlineRequestController extends Controller
{
    private $onlineRequests;

    public function __construct(OnlineRequestRepository $onlineRequestRepository)
    {
        $this->middleware('auth');
        $this->onlineRequests = $onlineRequestRepository;
    }

    /**
     * Show renewal request attachment file
     *
     * @param OnlineRenewalApplicationRequest $renewal
     * @return RedirectResponse
     */
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
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
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
            compact(
                'renewalApplications',
                'newApplications',
                'businessScales',
            )
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
        $certificate = $this->onlineRequests->getCertificateByCertificateNumber($renewal->certificate_number, $renewal->renewal_type);
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

    /**
     * Sends payment link SMS and email for the given OnlineRequest
     *
     * @param Request $request
     * @param OnlineRequest $onlineRequest
     * @return RedirectResponse
     */
    public function sendPaymentLink(Request $request, OnlineRequest $onlineRequest)
    {
        // dd($onlineRequest);
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
            $mobileNumber = $application->client->contact_no;
        }
        // dd($application);
        // create online payment record
        $onp = OnlinePayment::create([
            'online_request_id' => $onlineRequest->id,
            'reference_no' => Str::uuid()->toString(),
            'amount' => $paymentAmount,
        ]);

        // generate a signed URL
        $paymentLink = URL::temporarySignedRoute(
            'online-request.pay',
            now()->addWeek(), // will expire after 1 week/7 days
            ['id' => $onlineRequest->id, 'pid' => $onp->id]
        );

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
            $smsMessage = "Hello,\nPlease follow the link to make your payment for " . $onlineRequest->request_type . " request.\n${paymentLink}\nEnvironment Authority NWP";
            $isSent = SmsHelper::sendSms($mobileNumber, $smsMessage);
        }

        // set return route
        $returnId = $onlineRequest->online_request_id;
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
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
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

    /**
     * Register payment request from transaction and send payment links
     *
     * @param Request $request
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function registerAndSendOnlinePaymentLinksForTransaction(Request $request, Transaction $transaction)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'payment_amount' => 'required|numeric',
        ], $request->all());

        // create online request for request type transaction with transaction id
        $onlineRequest = OnlineRequest::create([
            'request_type' => 'payment', 'status' => 'pending', 'request_id' => $transaction->id,
            'request_model' => Transaction::class, 'online_request_id' => $transaction->id,
        ]);

        // dd($transaction);
        // send SMS and email
        return $this->sendPaymentLink($request, $onlineRequest);
    }

    /**
     * Reject new application request
     *
     * @param Request $request
     * @param OnlineNewApplicationRequest $newApplication
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function rejectNewRequest(Request $request, OnlineNewApplicationRequest $newApplication)
    {
        $newApplication->rejected_at = Carbon::now()->format('Y-m-d H:i:s');
        $newApplication->rejected_minute = $request->rejected_minute;
        $newApplication->status = 'rejected';
        $newApplication->save();

        // if (!empty($newApplication->mobile_number)) {
        //     $smsMessage = "Hello,\nPlease";
        //     $isSent = SmsHelper::sendSms($newApplication->mobile_number, $smsMessage);
        // }

        return redirect()->route('online-requests.index')->with('rejected_success', 'New application request rejected.');
    }

    public function viewNewApplicationDetailsRequest(OnlineNewApplicationRequest $newApplication)
    {
        $onlineReq = OnlineRequest::where('id', $newApplication->online_request_id)->first();

        $model = str_replace('\Models', '', $onlineReq->request_model);
        $applicationData = $model::where('id', $onlineReq->request_id)->first();

        switch ($model) {
            case 'App\RefilingPaddyLand':
                return view('online-requests.print-application.refiling-paddy', compact('applicationData'));
                break;
            case 'App\TreeFelling':
                return view('online-requests.print-application.tree-felling-details', compact('applicationData'));
                break;
            case 'App\StateLandLease':
                return view('online-requests.print-application.state-land-lease-details', compact('applicationData'));
                break;
            case 'App\TelecommunicationTower':
                return view('online-requests.print-application.telecommunication-tower-details', compact('applicationData'));
                break;
            case 'App\OnlineSiteClearance':
                return view('online-requests.print-application.sc-details', compact('applicationData'));
                break;
            case 'App\OnlineNewEpl':
                return view('online-requests.print-application.epl-details', compact('applicationData'));
                break;
            case 'App\OnlineRenewalEpl':
                return view('online-requests.print-application.renewal-epl-details', compact('applicationData'));
                break;
            case 'App\WasteManagement':
                return view('online-requests.print-application.waste-management', compact('applicationData'));
                break;
            default:
                # code...
                break;
        }
    }

    public function viewRenewalApplicationDetailsRequest(OnlineRenewalApplicationRequest $renewalApplication)
    {
        // dd($renewalApplication);
        $onlineRenewalReq = OnlineRequest::where('id', $renewalApplication->online_request_id)->first();

        $model = str_replace('\Models', '', $onlineRenewalReq->request_model);
        $applicationData = $model::where('id', $onlineRenewalReq->request_id)->first();
        // dd($applicationData);

        // return $applicationData;
        switch ($model) {
            case 'App\OnlineRenewalEpl':
                return view('online-requests.print-application.renewal-epl-details', compact('applicationData'));
                break;
            case 'App\OnlineSiteClearance':
                return view('online-requests.print-application.sc-details', compact('applicationData'));
                break;
            default:
                # code...
                break;
        }
    }
}
