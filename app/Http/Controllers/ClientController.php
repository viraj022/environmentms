<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Certificate;
use App\Level;
use App\Client;
use Carbon\Carbon;
use App\BusinessScale;
use App\Pradesheeyasaba;
use App\Rules\contactNo;
use App\IndustryCategory;
use App\Rules\nationalID;
use App\EnvironmentOfficer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\SiteClearenceSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogActivity;

class ClientController extends Controller {

    public function __construct() {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('client_space', ['pageAuth' => $pageAuth]);
    }

    public function indexOldFileList() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_file_list', ['pageAuth' => $pageAuth]);
    }

    public function indexOldDataReg($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_data_registation', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    public function allClientsindex() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.industryFile'));
        if ($pageAuth['is_read']) {
            return view('industry_files', ['pageAuth' => $pageAuth]);
        } else {
            abort(401);
        }
    }

    public function index1($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            return view('industry_profile', ['pageAuth' => $pageAuth, 'id' => $id]);
        } else {
            abort(401);
        }
    }

    public function updateClient($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('update_industry_file', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    public function certificatesUi() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('pending_certificates', ['pageAuth' => $pageAuth]);
    }

    public function certificatePrefer($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('certificate_perforation', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable',
            'contact_no' => ['nullable', new contactNo],
            'email' => 'nullable|sometimes',
            'nic' => ['sometimes', 'nullable', 'unique:clients', new nationalID],
            'industry_name' => 'required|string',
            'industry_category_id' => 'required|integer',
            'business_scale_id' => 'required|integer',
            'industry_contact_no' => ['nullable', new contactNo],
            'industry_address' => 'required|string',
            'industry_email' => 'nullable|email',
            'industry_coordinate_x' => ['numeric', 'required', 'between:-180,180'],
            'industry_coordinate_y' => ['numeric', 'required', 'between:-90,90'],
            'pradesheeyasaba_id' => 'required|integer',
            'industry_is_industry' => 'required|integer',
            'industry_investment' => 'required|numeric',
            'industry_start_date' => 'required|date',
            'industry_registration_no' => 'nullable|string',
            'is_old' => 'required|integer',
                // 'password' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            $client = new Client();
            $client->first_name = \request('first_name');
            $client->last_name = \request('last_name');
            $client->address = \request('address');
            $client->contact_no = \request('contact_no');
            $client->email = \request('email');
            $client->nic = \request('nic');
            $client->password = Hash::make(request('nic'));
            $client->api_token = Str::random(80);

            $client->industry_name = \request('industry_name');
            $client->industry_category_id = \request('industry_category_id');
            $client->business_scale_id = \request('business_scale_id');
            $client->industry_contact_no = \request('industry_contact_no');
            $client->industry_address = \request('industry_address');
            $client->industry_email = \request('industry_email');
            $client->industry_coordinate_x = \request('industry_coordinate_x');
            $client->industry_coordinate_y = \request('industry_coordinate_y');
            $client->pradesheeyasaba_id = \request('pradesheeyasaba_id');
            $client->industry_is_industry = \request('industry_is_industry');
            $client->industry_investment = \request('industry_investment');
            $client->industry_start_date = \request('industry_start_date');
            $client->industry_registration_no = \request('industry_registration_no');
            $client->is_old = \request('is_old');

            $msg = $client->save();
            $client->file_no = $this->generateCode($client);
            // dd($client->file_no);
            $msg = $msg && $client->save();
            LogActivity::fileLog($client->id, 'CNFILE', "Create New File", 1);
            if ($msg) {
                return array('id' => 1, 'message' => 'true', 'id' => $client->id);
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    private function generateCode($client) {
        $la = Pradesheeyasaba::find($client->pradesheeyasaba_id);
        // print_r($la);
        $lsCOde = $la->code;

        $industry = IndustryCategory::find($client->industry_category_id);
        $industryCode = $industry->code;
        $scale = BusinessScale::find($client->business_scale_id);
        $scaleCode = $scale->code;

        $e = Client::orderBy('id', 'desc')->first();
        if ($e === null) {
            $serial = 1;
        } else {
            $serial = $e->id;
        }
        $serial = sprintf('%02d', $serial);
        return "PEA/" . $lsCOde . "/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'first_name' => 'sometimes|required|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable',
            'contact_no' => ['nullable', new contactNo],
            'email' => 'nullable|sometimes',
            'nic' => ['nullable', 'unique:users,nic,' . $id, new nationalID],
            'industry_name' => 'sometimes|required|string',
            'industry_category_id' => 'sometimes|required|integer',
            'business_scale_id' => 'sometimes|required|integer',
            'industry_contact_no' => ['nullable', new contactNo],
            'industry_address' => 'sometimes|required|string',
            'industry_email' => 'nullable|email',
            'industry_coordinate_x' => ['sometimes', 'numeric', 'required', 'between:-180,180'],
            'industry_coordinate_y' => ['sometimes', 'numeric', 'required', 'between:-90,90'],
            'pradesheeyasaba_id' => 'sometimes|required|integer',
            'industry_is_industry' => 'sometimes|required|integer',
            'industry_investment' => 'sometimes|required|numeric',
            'industry_start_date' => 'sometimes|required|date',
            'industry_registration_no' => 'nullable|string',
            'is_old' => 'sometimes|required|integer',
                // 'password' => 'required',
        ]);
        if ($pageAuth['is_update']) {
            $msg = Client::where('id', $id)->update($request->all());
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function getClientById($id) {
        return Client::findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            return Client::get();
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_delete']) {
            $client = Client::findOrFail($id);
            $msg = $client->delete();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function findClient_by_nic($nic) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        return Client::with('epls')->with('oldFiles')->where('nic', '=', $nic)
                        ->get();
    }

    public function findClient_by_id($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        $file = Client::with('epls')->with('environmentOfficer.user')->with('oldFiles')->with('industryCategory')->with('businessScale')->with('pradesheeyasaba')->find($id)->toArray();
        $file['created_at'] = date('Y-m-d', strtotime($file['created_at']));
        $file['industry_start_date'] = date('Y-m-d', strtotime($file['industry_start_date']));
        return $file;
    }

    public function getAllFiles($id) {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::where('environment_officer_id', $envOfficer->id)->get();
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
        return $data;
    }

    public function workingFiles($id) {
        return array('id' => 'API removed contact hansana');
        // $data = array();
        // $user = Auth::user();
        // $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        // if ($user->roll->level->name == Level::DIRECTOR) {
        //     $data = Client::where('environment_officer_id', $id)->where('is_working', 1)->get();
        // } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
        //     $data = Client::where('environment_officer_id', $id)->where('is_working', 1)->get();
        // } else if ($user->roll->level->name == Level::ENV_OFFICER) {
        //     $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
        //     if ($envOfficer) {
        //         $data = Client::where('environment_officer_id', $user->id)->where('is_working', 1)->get();
        //     } else {
        //         abort(404);
        //     }
        // } else {
        //     abort(401);
        // }
        // //    Client::where()
        // return $data;
    }

    public function newlyAssigned($id) {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::where('environment_officer_id', $envOfficer->id)->get();
            }
        } else {
            abort(401);
        }

        return $data;
    }

    public function inspection_needed_files($id) {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)
                    ->where('need_inspection', Client::STATUS_INSPECTION_NEEDED)
                    ->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)
                    ->where('need_inspection', Client::STATUS_INSPECTION_NEEDED)
                    ->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::where('environment_officer_id', $envOfficer->id)
                        ->where('need_inspection', Client::STATUS_INSPECTION_NEEDED)
                        ->get();
            }
        } else {
            abort(401);
        }
        return $data;
    }

    public function inspection_pending_needed_files($id) {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::with('inspectionSessions')->whereHas('inspectionSessions', function ($sql) {
                        return $sql->where('inspection_sessions.status', '=', 0);
                    })->where('environment_officer_id', $id)
                    ->where('need_inspection', Client::STATUS_PENDING)
                    ->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::with('inspectionSessions')->whereHas('inspectionSessions', function ($sql) {
                        return $sql->where('inspection_sessions.status', '=', 0);
                    })->where('environment_officer_id', $id)
                    ->where('need_inspection', Client::STATUS_PENDING)
                    ->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::with('inspectionSessions')->whereHas('inspectionSessions', function ($sql) {
                            return $sql->where('inspection_sessions.status', '=', 0);
                        })->where('environment_officer_id', $envOfficer->id)
                        ->where('need_inspection', Client::STATUS_PENDING)
                        ->get();
            }
        } else {
            abort(401);
        }
        return $data;
    }

    public function getOldFiles() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        return Client::where('is_old', 0)->with('epls')->with('oldFiles')->get();
    }

    public function markOldFinish($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::find($id);
        $client->is_old = 2; // inspected state

        if ($client->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getOldFilesDetails($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::where('is_old', 0)->where('id', $id)->first();
        if ($client) {
            $epls = $client->epls;
            //            dd($client);
            if (count($epls) > 0) {
                return $client->epls[0];
            } else {
                return $epls;
            }
        } else {
            abort(404);
        }
    }

    public function getOldSiteClearanceData($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::where('is_old', 0)->where('id', $id)->first();
        if ($client) {
            $siteClearance = $client->siteClearenceSessions;
            if (count($siteClearance) > 0) {
                $siteClearanceSession = $client->siteClearenceSessions[0];
                $siteClearanceSession->site_clearances = $siteClearanceSession->siteClearances[0];
                return $siteClearanceSession;
            } else {
                return $siteClearance;
            }
        } else {
            abort(404);
        }
    }

    public function markInspection($inspectionNeed, $id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::findOrFail($id);
        if ($inspectionNeed == 'needed') {
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NEEDED;
        } else if ($inspectionNeed == 'no_needed') {
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NOT_NEEDED;
        } else {
            abort(422);
        }
        if ($client->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function file_problem_status($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'file_problem_status' => ['required', 'regex:(pending|clean|problem)'],
            'file_problem_status_description' => 'required|string',
        ]);

        $file = Client::findOrFail($id);
        $file->file_problem_status = \request('file_problem_status');
        $file->file_problem_status_description = \request('file_problem_status_description');
        if ($file->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function changeFileStatus($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'status_type' => 'required|string',
            'status_code' => 'required|string',
            'status_value' => 'nullable|string',
        ]);
        if (setFileStatus($id, \request('status_type'), \request('status_code'), \request('status_value'))) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getDirectorPendingList() {
        return Client::getFileByStatusQuery('file_status', array(-2, 6))->get();
    }

    public function getAssistanceDirectorPendingList($id) {
        return Client::getFileByStatusQuery('file_status', array(1, 3))->whereHas('environmentOfficer.assistantDirector', function ($query) use ($id) {
                    $query->where('assistant_directors.id', $id);
                })->get();
    }

    public function getEnvironmentOfficerPendingList($id) {
        return Client::getFileByStatusQuery('file_status', array(0))->whereHas('environmentOfficer', function ($query) use ($id) {
                    $query->where('environment_officers.id', $id);
                })->get();
    }

    public function getCertificateDraftingList() {
        return Client::getFileByStatusQuery('file_status', array(2))->where('cer_type_status', '!=', 0)->get();
    }

    public function nextCertificateNumber($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $client = Client::findOrFail($id);
        $certificate = new Certificate();

        if ($client->cer_type_status == 1 || $client->cer_type_status == 2) {
            //epl certificate
            $certificate->certificate_type = 0;
        } elseif ($client->cer_type_status == 3 || $client->cer_type_status == 4) {
            $certificate->certificate_type = 1;
        }
        $certificate->cetificate_number = $client->generateCertificateNumber();

        $certificate->client_id = $client->id;
        $certificate->issue_status = 0;
        $certificate->user_id = $user->id;

        // $certificate->save();

        $msg = $certificate->save();

        $cerNo = Setting::Where('name', 'certificate_ai')->first();
        $cerNo->value = $certificate->cetificate_number;
        $cerNo->save();
        setFileStatus($client->id, 'cer_status', 1);
        fileLog($client->id, 'StartDrafting', 'User (' . $user->user_name . ')  Start certificate drafting', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true', 'certificate_number' => $certificate->cetificate_number);
        } else {
            return array('id' => 0, 'message' => 'false');
        }

        //  return $client->generateCertificateNumber();
    }


    public function getCertificateDetails($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        $client = Client::findOrFail($id);
        $certificate = Certificate::with('client')->where('client_id', $client->id)->where('issue_status', 0)->orderBy('id', 'desc')->first();
        if (!$certificate) {
            return array();
        } else {
            return $certificate;
        }
    }

    public function uploadCertificate($id, Request $request)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        $type = $request->file->extension();
        $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
        $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/draft/" . $id;
        $storePath = 'public' . $fileUrl;
        $path = 'storage' . $fileUrl . "/" . $file_name;
        $request->file('file')->storeAs($storePath, $file_name);
        $certificate->certificate_path = $path;
        $certificate->user_id_certificate_upload =  $user;
        $certificate->certificate_upload_date = Carbon::now();
        fileLog($certificate->client, 'certificate', 'User (' . $user->user_name . ')  uploaded the draft certificate', 0);
        if ($certificate->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function uploadOriginalCertificate($id, Request $request)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        $type = $request->file->extension();
        $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
        $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/original/" . $id;
        $storePath = 'public' . $fileUrl;
        $path = 'storage' . $fileUrl . "/" . $file_name;
        $request->file('file')->storeAs($storePath, $file_name);
        $certificate->certificate_path = $path;
        $certificate->user_id_certificate_upload =  $user;
        $certificate->certificate_upload_date = Carbon::now();
        fileLog($certificate->client, 'certificate', 'User (' . $user->user_name . ')  uploaded the original certificate', 0);
        if ($certificate->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }


























    // hansana
    public function completeDraftingCertificate($id){
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);

        $msg = setFileStatus($certificate->client_id, 'file_status', 2);
        $msg = $msg && setFileStatus($certificate->client_id, 'cer_status', 2);

        fileLog($certificate->client_id, 'FileStatus', 'User (' . $user->user_name . ') Finish drafting the certificate', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }


    // hansna a 
}
