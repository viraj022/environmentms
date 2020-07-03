<?php

namespace App\Http\Controllers;

use App\EPL;
use App\BusinessScale;
use App\Client;
use App\Pradesheeyasaba;
use App\Rules\contactNo;
use App\IndustryCategory;
use App\IssueLog;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EPLController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (Client::find($id) !== null) {
                return view('epl_register', ['pageAuth' => $pageAuth, 'id' => $id]);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function index2()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            return view('application_payment', ['pageAuth' => $pageAuth]);
        } else {
            abort(401);
        }
    }

    public function profile($client, $profile)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (Client::find($client) !== null && EPL::find($profile) !== null) {
                return view('epl_profile', ['pageAuth' => $pageAuth, 'client' => $client, 'profile' => $profile]);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function attachment_upload_view($epl_id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $EPL = EPL::find($epl_id);
        if ($pageAuth['is_read']) {
            if ($EPL !== null) {
                return view('epl_attachment_upload', ['pageAuth' => $pageAuth, 'epl_id' => $epl_id, "epl_number" => $EPL->code, "client" => $EPL->client_id]);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function issue_certificate($epl_id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $epl = EPL::find($epl_id);
            if ($epl !== null) {
                // dd($epl->issue_date);
                if ($epl->issue_date == null) {
                    $payList = $epl->paymentList();
                    if (
                            $payList['inspection']['status'] == 'payed' && $payList['license_fee']['status'] == 'payed' && ($payList['fine']['status'] == 'payed' || $payList['fine']['status'] == 'not_available')
                    ) {

                        request()->validate([
                            'issue_date' => 'required|date',
                            'expire_date' => 'required|date',
                            'certificate_no' => 'required|string',
                        ]);
                        return \DB::transaction(function () use ($epl, $user) {
                                    $epl->issue_date = request('issue_date');
                                    $epl->expire_date = request('expire_date');
                                    $epl->certificate_no = request('certificate_no');
                                    $msg = $epl->save();
                                    if ($msg) {
                                        $issueLog = new IssueLog();
                                        $issueLog->certificate_type = IssueLog::CER_EPL;
                                        $issueLog->issue_type = IssueLog::CER_EPL;
                                        $issueLog->issue_id = $epl->id;
                                        $issueLog->issue_date = request('issue_date');
                                        $issueLog->expire_date = request('expire_date');
                                        $issueLog->user_id = $user->id;
                                        $msg = $issueLog->save();
                                        if ($msg) {
                                            return response(array('id' => 1, 'message' => 'success'), 200);
                                        } else {
                                            return response(array('id' => 0, 'message' => 'fail'), 200);
                                        }
                                    } else {
                                        abort(500);
                                    }
                                });
                    } else {
                        return response(array('id' => 0, 'message' => 'Payment no completed'), 403);
                    }
                } else {
                    return response(array('id' => 0, 'message' => 'Certificate already issued'), 403);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $msg = \DB::transaction(function () {
                request()->validate([
                    'name' => 'required|unique:e_p_l_s,name',
                    'client_id' => 'required|integer',
                    'industry_category_id' => 'required|integer',
                    'contact_no' => ['required', new contactNo],
                    'address' => ['required'],
                    'email' => ['sometimes', 'nullable'],
                    'coordinate_x' => ['numeric', 'nullable', 'between:-180,180'],
                    'coordinate_y' => ['numeric', 'nullable', 'between:-90,90'],
                    'pradesheeyasaba_id' => 'required|integer',
                    'is_industry' => 'required|integer',
                    'investment' => 'required|numeric',
                    'start_date' => 'required|date',
                    'business_scale_id' => 'required|integer',
                    'registration_no' => ['sometimes', 'nullable', 'unique:e_p_l_s,registration_no'],
                    'remark' => ['sometimes', 'nullable'],
                    'created_date' => 'required|date',
                    'is_old' => 'required|integer',
                ]);
                $epl = new EPL();
                $epl->name = \request('name');
                $epl->client_id = \request('client_id');
                $epl->industry_category_id = \request('industry_category_id');
                $epl->business_scale_id = \request('business_scale_id');
                $epl->contact_no = \request('contact_no');
                $epl->address = \request('address');
                $epl->email = \request('email');
                $epl->coordinate_x = \request('coordinate_x');
                $epl->coordinate_y = \request('coordinate_y');
                $epl->pradesheeyasaba_id = \request('pradesheeyasaba_id');
                $epl->is_industry = \request('is_industry');
                $epl->investment = \request('investment');
                $epl->start_date = \request('start_date');
                $epl->registration_no = \request('registration_no');
                $epl->remark = \request('remark');
                $epl->code = $this->generateCode($epl);
                $epl->application_path = "";
                $epl->created_at =  \request('created_date');
                $epl->is_old =  \request('is_old');
                $msg = $epl->save();

                if ($msg) {
                    $data = \request('file');
                    $array = explode(';', $data);
                    $array2 = explode(',', $array[1]);
                    $array3 = explode('/', $array[0]);
                    $type = $array3[1];
                    $data = base64_decode($array2[1]);
                    file_put_contents($this->makeApplicationPath($epl->id) . "1." . $type, $data);
                    $epl->application_path = $this->makeApplicationPath($epl->id) . "1." . $type;
                    $epl->save();
                    return array('id' => 1, 'message' => 'true', 'rout' => "/epl_profile/client/" . $epl->client_id . "/profile/" . $epl->id);
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            });
            return $msg;
        } else {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function find($id)
    {
        return EPL::leftJoin('environment_officers', 'e_p_l_s.environment_officer_id', 'environment_officers.id')
            ->leftJoin('users', 'environment_officers.user_id', 'users.id')
            ->where('e_p_l_s.id', $id)
            ->select('e_p_l_s.*', 'users.first_name', 'users.last_name')
            ->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function show(EPL $ePL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function edit(EPL $ePL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EPL $ePL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function destroy(EPL $ePL)
    {
        //
    }

    private function generateCode($epl)
    {
        $la = Pradesheeyasaba::find($epl->pradesheeyasaba_id);
        // print_r($la);
        $lsCOde = $la->code;

        $industry = IndustryCategory::find($epl->industry_category_id);
        $industryCode = $industry->code;
        $scale = BusinessScale::find($epl->business_scale_id);
        $scaleCode = $scale->code;

        $e = EPL::orderBy('id', 'desc')->first();
        if ($e === null) {
            $serial = 1;
        } else {
            $serial = $e->id;
        }
        $serial = sprintf('%02d', $serial);
        return "PEA/" . $lsCOde . "/EPL/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
    }

    private function makeApplicationPath($id)
    {
        if (!is_dir("uploads")) {
            //Create our directory if it does not exist
            mkdir("uploads");
        }
        if (!is_dir("uploads/EPL")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL");
        }
        if (!is_dir("uploads/EPL/" . $id)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id);
        }
        if (!is_dir("uploads/EPL/" . $id . "/application")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/application");
        }
        return "uploads/EPL/" . $id . "/application/";
    }

    public function addInspectionPayment()
    {
        $epl = EPL::find(\request('id'));
        if ($epl !== null) {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
            if ($pageAuth['is_create']) {
                request()->validate([
                    'payment_id' => 'required|integer',
                    'id' => 'required|integer',
                    'amount' => 'required|numeric',
                ]);
                $transaction = array();
                $transaction['payment_type_id'] = Payment::find(\request('payment_id'))->payment_type_id;
                $transaction['payment_id'] = \request('payment_id');
                $transaction['transaction_type'] = EPL::EPL;
                $transaction['transaction_id'] = $epl->id;
                $transaction['amount'] = \request('amount');
                $transaction['status'] = 0;
                $transaction['type'] = EPL::INSPECTION;
                $msg = TransactionController::create($transaction);
                if ($msg) {
                    return $this->addInspectionFine($epl);
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(401);
            }
        } else {
            abort(404);
        }
    }

    public function getInspectionPaymentDetails($epl)
    {
        $epl = EPL::find($epl);
        if ($epl !== null) {
            return $epl->paymentDetails();
        } else {
            return abort(404);
        }
    }

    public function newEpls()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            return EPL::whereNull('environment_officer_id')->get();
        } else {
            return abort(4010);
        }
    }

    public function addSiteClearance($epl)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'site_clearance_file' => 'required|string',
            ]);
            $epl = EPL::find($epl);
            if ($epl) {
                /// need to validate if the site clearence file number actually exiests
                $epl->site_clearance_file = \request('site_clearance_file');
                $msg = $epl->save();
                if ($msg) {
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }
}
