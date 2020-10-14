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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogActivity;
use Illuminate\Database\Eloquent\Builder;
use App\EPL;
use App\SiteClearenceSession;

class ClientController extends Controller
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
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('client_space', ['pageAuth' => $pageAuth]);
    }

    public function indexOldFileList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_file_list', ['pageAuth' => $pageAuth]);
    }

    public function indexOldDataReg($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_data_registation', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    public function allClientsindex()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.industryFile'));
        if ($pageAuth['is_read']) {
            return view('industry_files', ['pageAuth' => $pageAuth]);
        } else {
            abort(401);
        }
    }

    public function index1($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            return view('industry_profile', ['pageAuth' => $pageAuth, 'id' => $id]);
        } else {
            abort(401);
        }
    }

    public function updateClient($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('update_industry_file', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    public function certificatesUi()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('pending_certificates', ['pageAuth' => $pageAuth]);
    }

    public function expireCertificatesUi()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('expired_certificates', ['pageAuth' => $pageAuth]);
    }

    public function certificatePrefer($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('certificate_perforation', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'name_title' => 'required|string',
            'industry_sub_category' => 'nullable|string',
            // 'password' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            $client = new Client();
            $client->name_title = \request('name_title');
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
            $client->industry_sub_category = \request('industry_sub_category');
            $client->is_old = \request('is_old');

            $msg = $client->save();
            $client->file_no = $this->generateCode($client);
            // dd($client->file_no);
            $msg = $msg && $client->save();
            LogActivity::fileLog($client->id, 'FileOP', "Create New File", 1);

            if ($msg) {
                LogActivity::addToLog('Create a new Industry File', $client);
                return array('id' => 1, 'message' => 'true', 'id' => $client->id);
            } else {
                LogActivity::addToLog('Fail to create new Industry File', $client);
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    private function generateCode($client)
    {
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
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'name_title' => 'sometimes|required|string',
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
            'industry_sub_category' => 'nullable|string',
            // 'password' => 'required',
        ]);
        if ($pageAuth['is_update']) {
            $msg = Client::where('id', $id)->update($request->all());
            // $client = Client::findOrFail($id);
            // LogActivity::fileLog($client->id, 'FileOP', "File updated", 1);
            // $msg = Client::where('id', $id)->update($request->all());
            return array('id' => 1, 'message' => 'true');
        } else {
            abort(401);
        }
    }

    public function getClientById($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
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
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_delete']) {
            $client = Client::findOrFail($id);
            $msg = $client->delete();
            if ($msg) {
                LogActivity::addToLog("File " . $id . " deleted", $client);
                LogActivity::fileLog($client->id, 'FileOP', "File " . $id . " deleted", 1);
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog("Fail to delete File " . $id, $client);
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function findClient_by_nic($nic)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        return Client::with('epls')->with('oldFiles')->where('nic', '=', $nic)
            ->get();
    }

    public function findClient_by_id($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        $file = Client::with('epls')->with('siteClearenceSessions')->with('environmentOfficer.user')->with('oldFiles')->with('industryCategory')->with('businessScale')->with('pradesheeyasaba')->find($id)->toArray();
        $file['created_at'] = date('Y-m-d', strtotime($file['created_at']));
        $file['industry_start_date'] = date('Y-m-d', strtotime($file['industry_start_date']));
        return $file;
    }

    public function getAllFiles($id)
    {
        //        dd('ffff');
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

    public function certificatePath($id)
    {
        $client = Client::findOrFail($id);
        return Certificate::where('client_id', $client->id)->orderBy('id', 'desc')->first();
    }

    public function workingFiles($id)
    {
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

    public function newlyAssigned($id)
    {
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

    public function inspection_needed_files($id)
    {
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

    public function inspection_pending_needed_files($id)
    {
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

    public function getOldFiles($count)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($count == -1) {
            return Client::where('is_old', 0)->with('epls')->with('oldFiles')->orderBy('id', 'desc')->get();
        } else {
            return Client::where('is_old', 0)->with('epls')->with('oldFiles')->take($count)->orderBy('id', 'desc')->get();
        }
        //        return Client::where('is_old', 0)->with('epls')->with('oldFiles')->orderBy('id', 'desc')->get();
    }

    public function markOldFinish($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::find($id);
        $client->is_old = 2; // inspected state

        if ($client->save()) {
            LogActivity::addToLog("markOldFinish done " . $id, $client);
            LogActivity::fileLog($client->id, 'FileOP', "markOldFinish", 1);
            return array('id' => 1, 'message' => 'true');
        } else {
            LogActivity::addToLog("markOldFinish fail " . $id, $client);
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getOldFilesDetails($id)
    {
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

    public function getOldSiteClearanceData($id)
    {
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

    public function markInspection($inspectionNeed, $id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::findOrFail($id);
        if ($inspectionNeed == 'needed') {
            LogActivity::fileLog($client->id, 'inspections', "inspection mark as needed", 1);
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NEEDED;
        } else if ($inspectionNeed == 'no_needed') {
            LogActivity::fileLog($client->id, 'inspections', "inspection mark as no needed", 1);
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NOT_NEEDED;
        } else {
            LogActivity::addToLog("markOldFinish done ", $client);
            abort(422);
        }
        if ($client->save()) {
            LogActivity::addToLog("mark inspection  done ", $client);
            return array('id' => 1, 'message' => 'true');
        } else {
            LogActivity::addToLog("fail to mark inspection ", $client);
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function file_problem_status($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'file_problem_status' => ['required', 'regex:(pending|clean|problem)'],
            'file_problem_status_description' => 'required|string',
        ]);

        $file = Client::findOrFail($id);
        $file->file_problem_status = \request('file_problem_status');
        $file->file_problem_status_description = \request('file_problem_status_description');
        LogActivity::fileLog($file->id, 'FileProblams', "set FileProblam status " . $file->file_problem_status, 1);
        if ($file->save()) {
            LogActivity::addToLog("mark inspection  status done ", $file);
            return array('id' => 1, 'message' => 'true');
        } else {
            LogActivity::addToLog("fail to mark inspection status  ", $file);
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function changeFileStatus($id)
    {
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

    public function getDirectorPendingList()
    {
        return Client::getFileByStatusQuery('file_status', array(-2, 4, 6))->get();
    }

    public function getAssistanceDirectorPendingList($id)
    {
        return Client::getFileByStatusQuery('file_status', array(1, 3))->whereHas('environmentOfficer.assistantDirector', function ($query) use ($id) {
            $query->where('assistant_directors.id', $id);
        })->get();
    }

    public function getEnvironmentOfficerPendingList($id)
    {
        return Client::getFileByStatusQuery('file_status', array(0))->whereHas('environmentOfficer', function ($query) use ($id) {
            $query->where('environment_officers.id', $id);
        })->get();
    }

    public function getCertificateDraftingList()
    {
        return Client::getFileByStatusQuery('file_status', array(2))->where('cer_type_status', '!=', 0)->get();
    }

    public function nextCertificateNumber($id)
    {
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
        $msg = $certificate->save();
        if ($client->cer_type_status == 1 || $client->cer_type_status == 2) {
            incrementSerial(Setting::CERTIFICATE_AI);
        }
        setFileStatus($client->id, 'cer_status', 1);
        fileLog($client->id, 'StartDrafting', 'User (' . $user->user_name . ')  Start certificate drafting', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true', 'certificate_number' => $certificate->cetificate_number);
        } else {
            return array('id' => 0, 'message' => 'false');
        }
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

    public function uploadCertificate(Request $request, $id)
    {
        request()->validate([
            'issue_date' => 'sometimes|required|date',
            'expire_date' => 'sometimes|required|date',
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf'
        ]);
        $user = Auth::user();
        $req = request()->all();
        unset($req['file']);
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        if ($request->exists('file')) {
            $type = $request->file->extension();
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/draft/" . $id;
            $storePath = 'public' . $fileUrl;
            $path = 'storage' . $fileUrl . "/" . $file_name;
            $request->file('file')->storeAs($storePath, $file_name);
            $req['user_id_certificate_upload'] = $user->id;
            $req['certificate_upload_date'] = Carbon::now()->toDateString();
            $req['certificate_path'] = $path;
        } else {
            abort(422, "file key not found , ctech validation");
        }
        $msg = Certificate::where('id', $id)->update($req);
        // $certificate
        // $certificate->certificate_path = $path;
        // $certificate->user_id_certificate_upload =  $user->id;
        // $certificate->certificate_upload_date = Carbon::now()->toDateString();
        fileLog($certificate->client_id, 'certificate', 'User (' . $user->user_name . ')  uploaded the draft certificate', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function uploadOriginalCertificate($id, Request $request)
    {
        request()->validate([
            'issue_date' => 'sometimes|required|date',
            'expire_date' => 'sometimes|required|date',
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf'
        ]);
        $user = Auth::user();
        $req = request()->all();
        unset($req['file']);
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        if ($request->exists('file')) {
            $type = $request->file->extension();
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/original/" . $id;
            $storePath = 'public' . $fileUrl;
            $path = 'storage' . $fileUrl . "/" . $file_name;
            $request->file('file')->storeAs($storePath, $file_name);
            $req['signed_certificate_path'] = $path;
            $req['user_id_certificate_upload'] = $user->id;
        } else {
            abort(422, "file key not found , ctech validation");
        }
        $msg = Certificate::where('id', $id)->update($req);
        // $certificate->signed_certificate_path = $path;
        // $certificate->user_id_certificate_upload =  $user->id;
        fileLog($certificate->client_id, 'certificate', 'User (' . $user->user_name . ')  uploaded the original certificate', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function issueCertificate($cer_id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $certificate = Certificate::findOrFail($cer_id);
        $file = Client::findOrFail($certificate->client_id);
        $msg = setFileStatus($file->id, 'file_status', 5);
        $msg = $msg && setFileStatus($file->id, 'cer_status', 6);
        $certificate->issue_status = 1;
        $certificate->user_id = $user->id;
        $msg = $msg && $certificate->save();
        $file = $certificate->client;
        if ($file->cer_type_status == 1 || $file->cer_type_status == 2) {
            $epl = EPL::where('client_id', $certificate->client_id)
                ->whereNull('issue_date')->first();
            $epl->issue_date = $certificate->issue_date;
            $epl->expire_date = $certificate->expire_date;
            $epl->certificate_no = $certificate->cetificate_number;
            $epl->status = 1;
            $msg = $msg && $epl->save();
        } else if ($file->cer_type_status == 3 || $file->cer_type_status == 4) {
            $site = SiteClearenceSession::where('client_id', $certificate->client_id)->whereNull('issue_date')->first();
            $site->issue_date = $certificate->issue_date;
            $site->expire_date = $certificate->expire_date;
            $site->licence_no = $certificate->cetificate_number;
            $site->status = 1;
            $msg = $msg && $site->save();
        } else {
            abort(501, "Invalid File Status - hcw error code");
        }




        fileLog($file->id, 'CerIssue', 'User  (' . $user->user_name . ') Issued the Certificate : ' . $certificate->cetificate_number, 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function completeDraftingCertificate($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);

        // $msg = setFileStatus($certificate->client_id, 'file_status', 2);
        $msg = setFileStatus($certificate->client_id, 'cer_status', 2);

        fileLog($certificate->client_id, 'FileStatus', 'User (' . $user->user_name . ') Finish drafting the certificate', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function completeCertificate($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        // $certificate->issue_status = 1;
        // $certificate->save();
        $file = Client::findOrFail($certificate->client_id);
        $msg = setFileStatus($certificate->client_id, 'file_status', 5);
        // $msg = setFileStatus($certificate->client_id, 'cer_status', 5);
        fileLog($certificate->client_id, 'FileStatus', 'DIrector (' . $user->user_name . ') Complete the certificate', 0);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getExpiredCertificatesByEnvOfficer($id)
    { //to get expired certificates and certificates that expired within a month by env officer id
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $date = Carbon::now();
        $date = $date->addDays(30);
        if ($pageAuth['is_read']) {

            $responses = Certificate::With('Client')->selectRaw('max(id) as id, client_id,expire_date')
                ->whereHas('Client', function ($query) use ($id) {
                    $query->where('environment_officer_id', '=', $id);
                })
                ->where('expire_date', '<', $date)
                ->groupBy('client_id')
                ->get();

            $reses = $responses->toArray();

            foreach ($reses as $k => $res) {


                $origin = date_create(date("Y-m-d"));
                $target = date_create(date($res['expire_date']));
                $interval = date_diff($origin, $target);


                if ($interval->format('%R%a days') > 0) {
                    $reses[$k]['due_date'] = $interval->format('Expire within %a days');
                } else {
                    $reses[$k]['due_date'] = "expired";
                }
            }

            return $reses;
        } else {
            abort(401);
        }
    }

    //end to get expired certificates and certificates that expired within a month by env officer id

    public function getExpiredCertificates()
    { //to all get expired certificates and certificates that expired within a month by env officer id
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));


        $date = Carbon::now();
        $date = $date->addDays(30);

        if ($pageAuth['is_read']) {
            $responses = Certificate::With('Client')->selectRaw('max(id) as id, client_id,expire_date')
                ->where('expire_date', '<', $date)
                ->groupBy('client_id')
                ->get();

            // $posts = App\Post::whereHas('comments', function (Builder $query) {
            //     $query->where('content', 'like', 'foo%');
            // })->get();
            $reses = $responses->toArray();

            foreach ($reses as $k => $res) {
                $origin = date_create(date("Y-m-d"));
                $target = date_create(date($res['expire_date']));
                $interval = date_diff($origin, $target);

                if ($interval->format('%R%a days') > 0) {
                    $reses[$k]['due_date'] = $interval->format('Expire within %a days');
                } else {
                    $reses[$k]['due_date'] = "expired";
                }
            }

            return $reses;
        } else {
            abort(401);
        }
    }
}
