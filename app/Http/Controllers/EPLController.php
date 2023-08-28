<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Client;
use App\Payment;
use App\Setting;
use App\IssueLog;
use Carbon\Carbon;
use App\BusinessScale;
use App\Pradesheeyasaba;
use App\IndustryCategory;
use App\Certificate;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
    public function index($id, $type)
    {
        $user = Auth::user();
        $client = Client::find($id);
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if ($client !== null) {
                return view('epl_register', ['pageAuth' => $pageAuth, 'id' => $id, 'type' => $type, 'file_no' => $client->file_no]);
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

    public function index3($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            $epl = EPL::find($id);
            if ($epl) {
                return view('issue_certificate', ['pageAuth' => $pageAuth, 'id' => $epl->id, 'epl_number' => $epl->code, "client" => $epl->client_id]);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function profile($client, $profile)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $certificate = Certificate::where('client_id', $client)->where('certificate_type', 0)->orderBy('created_at', 'desc')->first();
        if ($pageAuth['is_read']) {
            if (Client::find($client) !== null && EPL::find($profile) !== null) {
                return view('epl_profile', ['pageAuth' => $pageAuth, 'client' => $client, 'profile' => $profile, 'certificate' => $certificate]);
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

    public function issue_certificate($epl_id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $epl = EPL::find($epl_id);
            if ($epl !== null) {
                if ($epl->status == 0) {
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
                            $epl->status = 1;
                            $msg = $epl->save();

                            $client = Client::find($epl->client_id);
                            $msg = $msg && $client->save();
                            LogActivity::fileLog($client->id, 'EPL', "EPL Certificate Issued", 1, 'epl', $epl->id);
                            LogActivity::addToLog('Issue EPL Certificate', $epl);
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
    public function create(Request $request)
    {
        //get the last updated date
        $last_updated = Setting::where('name', 'epl_ai')
            ->select('updated_at')
            ->first();

        $is_outdated = $last_updated->updated_at->format('Y');

        if ($is_outdated != date("Y")) {
            return "Seting table must reset to generate EPL for new year";
        } else {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
            if ($pageAuth['is_create']) {
                $msg = \DB::transaction(function () use ($request) {
                    request()->validate([
                        //                    'client_id' => 'required|integer',
                        'remark' => ['sometimes', 'nullable'],
                        'startDate' => ['required', 'date'],
                        'inp' => 'required|mimes:jpeg,jpg,png,pdf'
                    ]);
                    $client = Client::where('file_no', '=', $request->file_no)->first();
                    $epl = new EPL();
                    $epl->client_id = $client->id;
                    $epl->remark = \request('remark');
                    $epl->code = $this->generateCode($client, 'new');
                    $client->application_path = "";
                    $epl->submitted_date = \request('startDate');
                    $epl->count = 0;
                    $msg = $epl->save();
                    if ($msg) {
                        $fileUrl = '/uploads/' . FieUploadController::getEPLApplicationFilePath($epl);
                        $path = $request->file('inp')->store($fileUrl);
                        $client->application_path = $path;
                        $epl->application_path = $path;
                        $client->save();
                        $epl->save();
                        incrementSerial(Setting::EPL_AI);
                        setFileStatus($epl->client_id, 'file_status', 0);  // set file status to zero
                        setFileStatus($epl->client_id, 'inspection', null);  //  set inspection pending status to 'null'
                        setFileStatus($epl->client_id, 'cer_type_status', 1);  // setificate type state to epl
                        setFileStatus($epl->client_id, 'cer_status', 0);  // set certificate status to 0
                        // setFileStatus($epl->client_id, 'file_problem', 0); // set file problem status to 0

                        LogActivity::addToLog('New EPL created', $epl);
                        LogActivity::fileLog($epl->client_id, 'EPL', "New EPL Added", 1, 'epl added', '');

                        return array('id' => 1, 'message' => 'true', 'rout' => "/epl_profile/client/" . $epl->client_id . "/profile/" . $epl->id);
                    } else {
                        LogActivity::addToLog(' Fail to  creted EPL and application path updated', $epl);
                        return array('id' => 0, 'message' => 'false');
                    }
                });
                return $msg;
            } else {
                abort(401);
            }
        }
    }

    public function renew(Request $request)
    {
        //get the last updated date
        $last_updated = Setting::where('name', 'epl_ai')
            ->select('updated_at')
            ->first();

        $is_outdated = $last_updated->updated_at->format('Y');

        if ($is_outdated != date("Y")) {
            return "Seting table must reset to renew EPL for new year";
        } else {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
            if ($pageAuth['is_create']) {
                $oldEpl = EPL::where('client_id', '=', request('client_id'))->orderBy('count', 'DESC')->first();
                if ($oldEpl->status == 0) {
                    return array('id' => 0, 'message' => 'EPL In Progress !');
                }
                $msg = \DB::transaction(function () use ($request) {
                    $client = Client::find(\request('client_id'));
                    $file_status = $client->file_status;
                    if ($file_status != 5) {
                        return array('id' => 0, 'message' => 'File not completed');
                    }
                    request()->validate([
                        'client_id' => 'required|integer',
                        'remark' => ['sometimes', 'nullable'],
                        'created_date' => ['required', 'date'],
                        'file' => 'required|mimes:jpeg,jpg,png,pdf'
                    ]);
                    $epl = new EPL();
                    $epl->client_id = \request('client_id');
                    $epl->remark = \request('remark');
                    $epl->code = $this->generateCode($client, 'renew');
                    $client->application_path = "";
                    $epl->submitted_date = \request('created_date');
                    $epl->count = $this->getEPLCount($epl->client_id) + 1;
                    $msg = $epl->save();
                    setFileStatus($epl->client_id, 'file_status', 0);  // set file status to zero
                    setFileStatus($epl->client_id, 'inspection', null);  //  set inspection pending status to 'null'
                    setFileStatus($epl->client_id, 'cer_type_status', 2);  // certificate type state to epl  renew
                    setFileStatus($epl->client_id, 'cer_status', 0);  // set certificate status to 0
                    setFileStatus($epl->client_id, 'file_problem', 0); // set file problem status to 0
                    if ($msg) {
                        $fileUrl = '/uploads/' . FieUploadController::getEPLApplicationFilePath($epl);
                        $path = $request->file('file')->store($fileUrl);
                        $epl->application_path = $path;
                        $client->application_path = $path;
                        $client->save();
                        $epl->save();
                        LogActivity::fileLog($client->id, 'EPL', "Add EPL renewal", 1, 'epl', $epl->id);
                        LogActivity::addToLog('EPL Renewal ' . $epl->id, $epl);
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
    }

    public function getEPLCount($client_id)
    {
        $epl = EPL::where('client_id', $client_id)->orderBy('id', 'DESC')->first();
        return $epl->count;
    }

    public function saveFile($epl, $type, Request $request)
    {
        request()->validate([
            'file' => 'sometimes|nullable|mimes:jpeg,jpg,png,pdf',
            'file1' => 'sometimes|nullable|mimes:jpeg,jpg,png,pdf',
            'file2' => 'sometimes|nullable|mimes:jpeg,jpg,png,pdf',
            'file3' => 'sometimes|nullable|mimes:jpeg,jpg,png,pdf',
        ]);
        $client = Client::find($epl);
        if ($client) {
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            switch ($type) {
                case 'file1':
                    $fileUrl = '/uploads/' . FieUploadController::getRoadMapPath($client);
                    $client->file_01 = $fileUrl . "/" . $file_name;
                    break;
                case 'file2':
                    $fileUrl = '/uploads/' . FieUploadController::getDeedFilePath($client);
                    $client->file_02 = $fileUrl . "/" . $file_name;
                    break;
                case 'file3':
                    $fileUrl = '/uploads/' . FieUploadController::getSurveyFilePath($client);
                    $client->file_03 = $fileUrl . "/" . $file_name;
                    break;
                default:
                    abort(422);
            }
            $path = $request->file('file')->storeAs($fileUrl, $file_name);
            if (!$path) {
                return array('id' => 0, 'message' => 'false');
            }
            $msg = $client->save();
            if ($msg) {
                LogActivity::fileLog($client->id, 'File', "Attachment saved", 1, 'File', $client->id);
                LogActivity::addToLog('Attachment saved', $client);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(404);
        }
    }

    public function getDeadList($id)
    {
        $client = Client::where('id', $id)->first();
        if (empty($client->file_02)) {
            return [];
        }
        $clientFile2 = $client->file_02;
        $files = Storage::files("public/uploads/industry_files/{$id}/application/file2");
        $links = array();
        foreach ($files as $file) {
            $fileName = str_replace("public", "storage", $file);
            $isLatest = basename($clientFile2) == basename($fileName);
            $links[] = [
                'file_name' => $fileName,
                'is_latest' => $isLatest,
            ];
        }
        return $links;
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
        $epl = EPL::with('client')->Join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->leftJoin('environment_officers', 'clients.environment_officer_id', 'environment_officers.id')
            ->leftJoin('users', 'environment_officers.user_id', 'users.id')
            ->where('e_p_l_s.id', $id)
            ->select('e_p_l_s.*', 'users.first_name', 'users.last_name')
            ->first()->toArray();
        $issueDate = date_create($epl['issue_date']);
        $todayDate = Carbon::now();
        $expireDate = date_create($epl['expire_date']);
        $dateDifference = date_diff($todayDate, $expireDate)->format('%y years, %m months and %d days');
        $epl['date_different'] = $dateDifference;
        $epl['issue_date'] = date_format($issueDate, "Y-m-d");
        $epl['expire_date'] = date_format($expireDate, "Y-m-d");
        return $epl;
    }

    public function getCertificateByCertificateNo(Request $req)
    {
        $number = $req->cert_no;
        return Certificate::where('certificates.cetificate_number', $number)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function show($epl_status)
    {
        return EPL::Join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->leftJoin('environment_officers', 'clients.environment_officer_id', 'environment_officers.id')
            ->leftJoin('users', 'environment_officers.user_id', 'users.id')
            ->where('e_p_l_s.is_old', $epl_status)
            ->select('e_p_l_s.*', 'users.first_name', 'users.last_name')
            ->get();
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
        if ($ePL->delete) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    private function generateCode($client, $status)
    {
        if ($status == 'new') {
            /**
             * For New Epl
             */
            $la = Pradesheeyasaba::find($client->pradesheeyasaba_id);
            $lsCOde = $la->code;
            $industry = IndustryCategory::find($client->industry_category_id);
            $industryCode = $industry->code;
            $scale = BusinessScale::find($client->business_scale_id);
            $scaleCode = $scale->code;
            $e = EPL::orderBy('id', 'desc')->first();
            $serial = getSerialNumber(Setting::EPL_AI);
            $serial = sprintf('%02d', $serial);
            return "PEA/" . $lsCOde . "/EPL/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
        } else if ($status == 'renew') {
            /**
             * For renew epl
             */
            $epl = $client->epls[0];
            return $epl->code;
        } else {
            /**
             * when file is in other status than new epl or epl renewal
             */
            abort(501, 'Invalid certificate type statues (1 / 2) - hcw error code');
        }
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
                    LogActivity::fileLog($epl->client_id, 'Payment', "Inspection payment added", 1, 'epl', $epl->id);
                    LogActivity::addToLog('Inspection payment added', $epl);
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

    /**
     * obsolete method
     */
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
                    LogActivity::fileLog($epl->client_id, 'site_clearance', "Site Clearance Added", 1, 'epl', $epl->id);
                    LogActivity::addToLog('Site Clearance Added', $epl);
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

    public function saveOldData($id, Request $request)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        // validations
        request()->validate([
            'epl_code' => 'required|string',
            'remark' => 'nullable|string',
            'issue_date' => 'required|date',
            'expire_date' => 'required|date',
            'certificate_no' => 'required|string',
            'count' => 'required|integer',
            'submit_date' => 'required|date',
            'file' => 'required|mimes:jpeg,jpg,png,pdf'
        ]);
        // save epl main file
        return \DB::transaction(function () use ($id, $request) {
            $client = Client::findOrFail($id);
            $epls = $client->epls;
            if (count($epls) > 0) {
                return response(array("id" => 2, "message" => 'Record Already Exist Please Update the existing record'), 403);
            }

            $epl = new EPL();
            $epl->client_id = $client->id;
            $epl->code = \request('epl_code');
            $epl->remark = \request('remark');
            $epl->issue_date = \request('issue_date');
            $epl->expire_date = \request('expire_date');
            $epl->certificate_no = \request('certificate_no');
            $epl->status = 1;
            $epl->count = \request('count');
            $epl->submitted_date = \request('submit_date');
            $msg = $epl->save();
            if ($msg) {
                if ($request->file('file') != null) {
                    $fileUrl = '/uploads/' . FieUploadController::getEPLCertificateFilePath($epl);
                    $path = $request->file('file')->store($fileUrl);
                    $epl->path = $path;
                    $msg = $epl->save();
                } else {
                    return response(array('id' => 1, 'message' => 'application not found'), 422);
                }
            } else {
                abort(500);
            }
            // sending response
            if ($msg) {
                LogActivity::addToLog('Save old epl data', $epl);
                LogActivity::fileLog($client->id, 'Old_data', "Save old EPL data", 1, 'epl', $epl->id);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function deleteOldData($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        // save epl main file
        $client = Client::findOrFail($id);
        $epls = $client->epls;
        if (count($epls) == 0) {
            abort(404);
        } else if (count($epls) == 1) {
            if ($epls[0]->delete()) {
                LogActivity::fileLog($client->id, 'Old_data', "Delete Old EPL Data", 1, 'epl', $epls->id);
                LogActivity::addToLog('Delete old data EPL data', $client);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            return response(array("id" => 2, "message" => "can't More the one record found"), 403);
        }
    }

    public function updateOldData($id, Request $request)
    {
        // dd('das');
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        // validations
        request()->validate([
            'epl_code' => 'required|string',
            'remark' => 'nullable|string',
            'issue_date' => 'required|date',
            'expire_date' => 'required|date',
            'certificate_no' => 'required|string',
            'count' => 'required|integer',
            'submit_date' => 'required|date',
            'file' => 'sometimes|nullable|mimes:jpeg,jpg,png,pdf'
        ]);
        // save epl main file
        return \DB::transaction(function () use ($id, $request) {
            $msg = true;
            $epl = EPL::findOrFail($id);
            $epl->code = \request('epl_code');
            $epl->remark = \request('remark');
            $epl->issue_date = \request('issue_date');
            $epl->expire_date = \request('expire_date');
            $epl->certificate_no = \request('certificate_no');
            $epl->count = \request('count');
            $epl->submitted_date = \request('submit_date');
            $msg = $msg && $epl->save();
            // save old data file
            if ($msg) {
                if ($request->file('file') != null) {
                    $fileUrl = '/uploads/' . FieUploadController::getEPLCertificateFilePath($epl);
                    $path = $request->file('file')->store($fileUrl);
                    $epl->path = $path;
                }
                $msg = $epl->save();
            } else {
                abort(500);
            }
            // sending response
            if ($msg) {
                LogActivity::addToLog('Update old EPL data', $epl);
                LogActivity::fileLog($epl->client_id, 'Old_data', "Update old EPL data", 1, 'epl', $epl->id);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function certificateInformation($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $epl = EPL::find($id);
        // dd($epl);
        if ($epl) {
            return $epl->certificateInfo();
        } else {
            abort(404);
        }
    }

    public function index4()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            return view('reverse_old_confirm', ['pageAuth' => $pageAuth]);
        } else {
            abort(401);
        }
    }
}
