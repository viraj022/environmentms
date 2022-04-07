<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Level;
use App\Client;
use App\Setting;
use Carbon\Carbon;
use App\Certificate;
use App\OldFiles;
use App\BusinessScale;
use App\Pradesheeyasaba;
use App\Rules\contactNo;
use App\IndustryCategory;
use App\Rules\nationalID;
use App\EnvironmentOfficer;
use Illuminate\Support\Str;
use App\Helpers\LogActivity;
use App\Repositories\UserNotificationsRepositary;
use App\SiteClearance;
use Illuminate\Http\Request;
use App\SiteClearenceSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class ClientController extends Controller
{

    private $userNotificationsRepositary;
    public function __construct(UserNotificationsRepositary $userNotificationsRepositary)
    {
        $this->userNotificationsRepositary = $userNotificationsRepositary;
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

    public function search_files()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('search_files', ['pageAuth' => $pageAuth]);
    }

    public function eo_locations()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('eo_locations', ['pageAuth' => $pageAuth]);
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
        if (!Auth::check()) {
            abort(401);
        }
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

    public function expireCertUi()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('expired_cert', ['pageAuth' => $pageAuth]);
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
            $client->created_user = $user->id;
            $client->is_old = \request('is_old');
            if ($client->is_old == 0) {
                $client->need_inspection = 'Inspection Not Needed';
            }
            $code = $this->generateCode($client);
            if (!$code || $code == null) {
                return array('id' => 0, 'message' => 'Error Generating file code!');
            }
            $client->file_no = $code;
            $client->save();
            if ($client) {
                LogActivity::fileLog($client->id, 'File', "Create New File", 1);
                LogActivity::addToLog('Create new file', $client);
                return array('id' => 1, 'message' => 'true', 'id' => $client->id);
            } else {
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
            'file_no' => 'nullable|string'
            // 'password' => 'required',
        ]);
        if ($pageAuth['is_update']) {

            try {
                DB::beginTransaction();

                $msg = Client::where('id', $id)->update($request->all());
                $epl = EPL::where('client_id', $id)->first();
                $site_clearsess = SiteClearenceSession::where('client_id', $id)->first();

                //load and split new file no to generate new epl code
                $splited_file_no = explode("/", $request->file_no);

                if (count($splited_file_no) != 6) {
                    return array('id' => 0, 'message' => 'Previous file number format is not correct');
                }

                if ($epl != null) {
                    //load and split previous epl no to generate new epl no for epl code
                    $splited_epl_no_prev = explode("/", $epl->code);
                    if (count($splited_epl_no_prev) != 7) {
                        return array('id' => 0, 'message' => 'Previous EPL number is not correct');
                    }

                    $new_epl_no = $splited_epl_no_prev[5] . '/' . $splited_epl_no_prev[6];
                    $epl->code = 'PEA/' . $splited_file_no[1] . '/EPL/' . $splited_file_no[2] . '/' . $splited_file_no[3] . '/' . $new_epl_no;
                    $epl->save();
                }

                if ($site_clearsess != null) {
                    //update the site clearence code
                    $splited_site_no_prev = explode("/", $site_clearsess->code);
                    if (count($splited_site_no_prev) != 7) {
                        return array('id' => 0, 'message' => 'Previous site clearence number is not correct');
                    }
                    $new_site_no = $splited_site_no_prev[5] . '/' . $splited_site_no_prev[6];
                    $site_clearsess->code = 'PEA/' . $splited_file_no[1] . '/SC/' . $splited_file_no[2] . '/' . $splited_file_no[3] . '/' . $new_site_no;
                    $site_clearsess->save();
                }

                DB::commit();
                LogActivity::fileLog($id, 'File', "Update file", 1);
                LogActivity::addToLog('Update file', $msg);
                return array('id' => 1, 'message' => 'File Number, EPL Number, Site clearence Number has updated successful');
            } catch (\Exception $ex) {
                DB::rollBack();
                return array('id' => 0, 'message' => 'File Number, EPL Number, Site clearence Number update is unsuccessful');
            }
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

    public function oldFilesCountByDate()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            $oldFilesList = Client::selectRaw("COUNT(*) count, DATE_FORMAT(created_at, '%Y %m %e') date")
                ->where('is_old', '0')
                ->Orwhere('is_old', '2')
                ->groupBy('date')
                ->orderBy('created_at', 'ASC')
                //                    ->toSql();
                ->get();

            return $oldFilesList;
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
                $msg1 = EPL::where('client_id', $id)->delete();
            }
            LogActivity::addToLog("Delete fIle", $client);
            LogActivity::fileLog($client->id, 'File', "Delete file", 1);
            if ($msg1) {
                return array('id' => 1, 'message' => 'true');
            } else {
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
        $file = Client::with('epls')->with('siteClearenceSessions.siteClearances')->with('environmentOfficer.user')->with('oldFiles')->with('industryCategory')->with('businessScale')->with('pradesheeyasaba')->find($id)->toArray();
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
        $data = Client::select('clients.*', 'site_clearence_sessions.code AS code_site', 'e_p_l_s.code AS code_epl')
            ->leftJoin('e_p_l_s', 'clients.id', '=', 'e_p_l_s.client_id')
            ->leftJoin('site_clearence_sessions', 'clients.id', '=', 'site_clearence_sessions.client_id');

        if ($user->roll->level->name == Level::DIRECTOR) {
            $data->where('environment_officer_id', $id);
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data->where('environment_officer_id', $id);
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data->where('environment_officer_id', $envOfficer->id);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
        $data->groupBy('clients.id');
        return $data->get();
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
        return DB::transaction(function () use ($id) {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $client = Client::find($id);
            $this->generateCertificateForOldData($client, $user);
            $client->is_old = 2; // inspected state
            $client->file_status = 5; // set file status
            $client->cer_status = 6; // set certificate status
            LogActivity::addToLog("Old file complete" . $id, $client);
            LogActivity::fileLog($client->id, 'File', "Old file complete", 1);
            if ($client->save()) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function markOldUnfinish($id)
    {
        return DB::transaction(function () use ($id) {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $client = Client::find($id);
            $client->is_old = 0; // inspected state
            $client->file_status = 0; // set file status
            $client->cer_status = 0; // set certificate status
            $client->save();
            $certificate = DB::table('certificates')
                ->where('client_id', '=', $id)
                ->delete();
            LogActivity::addToLog("Old file confirm revert" . $id, $client);
            LogActivity::fileLog($client->id, 'File', "Old file confirm revert", 1);
            if ($client == true) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function generateCertificateForOldData(Client $client, $user)
    {
        $epls = $client->epls;
        $siteClearances = $client->siteClearenceSessions;
        foreach ($epls as $epl) {
            $cer = Certificate::where('cetificate_number', $epl->certificate_no);
            if (!$cer) {
                $certificate = new Certificate();
                $certificate->client_id = $epl->client_id;
                $certificate->cetificate_number = $epl->certificate_no;
                $certificate->issue_date = $epl->issue_date;
                $certificate->expire_date = $epl->expire_date;
                $certificate->signed_certificate_path = $epl->path;
                $certificate->certificate_type = 0;
                $certificate->issue_status = 1;
                $certificate->user_id = $user->id;
                $certificate->save();
            }
        }

        foreach ($siteClearances as $siteClearance) {
            $sites = $siteClearance->siteClearances;
            foreach ($sites as $site) {
                $cer = Certificate::where('cetificate_number', $siteClearance->code);
                if (!$cer) {
                    $certificate = new Certificate();
                    $certificate->client_id = $siteClearance->client_id;
                    $certificate->cetificate_number = $siteClearance->code;
                    $certificate->issue_date = $site->issue_date;
                    $certificate->expire_date = $site->expire_date;
                    $certificate->signed_certificate_path = $site->certificate_path;
                    $certificate->certificate_type = 1;
                    $certificate->issue_status = 1;
                    $certificate->user_id = $user->id;
                    $certificate->save();
                }
            }
        }
    }

    public function getOldFilesDetails($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::where('is_old', 0)->where('id', $id)->first();
        if ($client) {
            $epls = $client->epls;
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
            LogActivity::fileLog($client->id, 'Inspection', "Mark inspection needed", 1);
            LogActivity::addToLog("Mark inspection needed", $client);
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NEEDED;
        } else if ($inspectionNeed == 'no_needed') {
            LogActivity::fileLog($client->id, 'Inspection', "Mark inspection no need", 1);
            LogActivity::addToLog("Mark inspection no need", $client);
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

    public function file_problem_status($id, Request $request)
    {
        try {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
            request()->validate([
                'file_problem_status' => ['required', 'regex:(pending|clean|problem)'],
                'file_problem_status_description' => 'required|string',
                'file' => $request->file != null ? 'sometimes|required|min:8' : ''
            ]);
            $file = Client::findOrFail($id);
            if (!($request->file == null || isset($request->file))) {
                $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                $fileUrl = '/uploads/' . FieUploadController::getOldFilePath($file);
                $storePath = 'public' . $fileUrl;
                $path = $request->file('file')->storeAs($storePath, $file_name);
                $oldFiles = new OldFiles();
                $oldFiles->path = "storage" . $fileUrl . "/" . $file_name;
                $oldFiles->type = $request->file->extension();
                $oldFiles->client_id = $file->id;
                $oldFiles->description = \request('description');
                $oldFiles->file_catagory = \request('file_catagory');
                $file->complain_attachment = "storage" . $fileUrl . "/" . $file_name;
                $msg = $oldFiles->save();
            }
            if (\request('file_problem_status') == 'clean') {
                $file->complain_attachment = null;
            }
            $file->file_problem_status = \request('file_problem_status');
            $file->file_problem_status_description = \request('file_problem_status_description');
            LogActivity::fileLog($file->id, 'File', "set File problem status " . $file->file_problem_status, 1);
            LogActivity::addToLog("Mark file problem status", $file);
            if ($file->save()) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } catch (Exception $ex) {
            return array('id' => 0, 'message' => 'false');
        }
    }

    //    public function file_problem_status($id) {
    //        $user = Auth::user();
    //        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
    //        request()->validate([
    //            'file_problem_status' => ['required', 'regex:(pending|clean|problem)'],
    //            'file_problem_status_description' => 'required|string',
    //            'file' => 'mimes:jpeg,jpg,png,pdf'
    //        ]);
    //
    //        $file = Client::findOrFail($id);
    //        $file->file_problem_status = \request('file_problem_status');
    //        $file->file_problem_status_description = \request('file_problem_status_description');
    //        $file->file = \request('file_problem_status_description');
    //        LogActivity::fileLog($file->id, 'File', "set File problem status " . $file->file_problem_status, 1);
    //        LogActivity::addToLog("Mark file problem status", $file);
    //        if ($file->save()) {
    //            return array('id' => 1, 'message' => 'true');
    //        } else {
    //            return array('id' => 0, 'message' => 'false');
    //        }
    //    }

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

    public function getDirectorApprovedList()
    {
        return Client::where('file_status', '=', 5)->where('cer_status', '=', 5)->with('epls')->get();
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

    public function getCertificateDraftingList($status)
    {
        return Client::getFileByStatusQuery('file_status', array(2))->where('cer_type_status', '!=', 0)->where('cer_status', $status)->get();
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
        if ($client->cer_type_status == 1) {
            incrementSerial(Setting::CERTIFICATE_AI);
        }
        setFileStatus($client->id, 'cer_status', 1);
        fileLog($client->id, 'Certificate', 'User (' . $user->last_name . ') Start drafting', 0);
        LogActivity::addToLog("Start certificate drafting", $client);
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
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf,doc,docx'
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

        fileLog($certificate->client_id, 'certificate', 'User (' . $user->last_name . ') uploaded draft', 0);
        LogActivity::addToLog("Upload Draft", $certificate);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function uploadCorrectedFile(Request $request, $id)
    {
        request()->validate([
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf,doc,docx'
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
            $req['corrected_file'] = $path;
        } else {
            abort(422, "file key not found , ctech validation");
        }
        $msg = Certificate::where('id', $id)->update($req);

        fileLog($certificate->client_id, 'certificate', 'User (' . $user->last_name . ') uploaded draft', 0);
        LogActivity::addToLog("Upload Corrected File", $certificate);
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

        fileLog($certificate->client_id, 'certificate', 'User (' . $user->user_name . ')  uploaded the original', 0);
        LogActivity::addToLog("Upload original", $certificate);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function issueCertificate($cer_id)
    {
        return DB::transaction(function () use ($cer_id) {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $certificate = Certificate::findOrFail($cer_id);
            if ($certificate->issue_status == 0) {
                $file = Client::findOrFail($certificate->client_id);
                $msg = setFileStatus($file->id, 'file_status', 5);
                $msg = $msg && setFileStatus($file->id, 'cer_status', 6);
                $certificate->issue_status = 1;
                $certificate->user_id = $user->id;
                $msg = $msg && $certificate->save();
                $file = $certificate->client;

                // check if => 1=new epl, 2=epl renew
                if ($file->cer_type_status == 1 || $file->cer_type_status == 2) {
                    $epl = EPL::where('client_id', $certificate->client_id)->whereNull('issue_date')->where('status', 0)->first();
                    $epl->issue_date = $certificate->issue_date;
                    $epl->expire_date = $certificate->expire_date;
                    $epl->certificate_no = $certificate->cetificate_number;
                    $epl->status = 1;
                    $msg = $msg && $epl->save();

                    //check if 3=site clearance
                } else if ($file->cer_type_status == 3) {
                    $site = SiteClearenceSession::where('client_id', $certificate->client_id)->whereNull('issue_date')->first();
                    $site->issue_date = $certificate->issue_date;
                    $site->expire_date = $certificate->expire_date;
                    $site->licence_no = $certificate->cetificate_number;
                    $site->status = 1;

                    $s = SiteClearance::where('site_clearence_session_id', $site->id)->where('status', 0)->first();
                    $s->status = 1;
                    $msg = $msg && $s->save();
                    $msg = $msg && $site->save();

                    //                            check if 4=site clearance renew
                } else if ($file->cer_type_status == 4) {
                    $site = SiteClearenceSession::where('client_id', $certificate->client_id)->orderBy('id', 'desc')->first();
                    $site->issue_date = $certificate->issue_date;
                    $site->expire_date = $certificate->expire_date;
                    $site->status = 1; //status already 1
                    $site->save();
                    $s = SiteClearance::where('site_clearence_session_id', $site->id)->where('status', 0)->first();
                    $s->status = 1;
                    $s->save();
                } else {
                    abort(501, "Invalid File Status - error code");
                }
            } else {
                abort(422, "Certificate Already Issued");
            }
            fileLog($file->id, 'certificate', 'User (' . $user->last_name . ') Issued the Certificate', 0);
            LogActivity::addToLog("Issue certificate", $certificate);
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function completeDraftingCertificate($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::with('client.environmentOfficer')->whereId($id)->first();
        $client = $certificate->client;
        // dd($client);
        $msg = setFileStatus($certificate->client_id, 'cer_status', 2);
        fileLog($certificate->client_id, 'certificate', 'User (' . $user->first_name . ' ' . $user->last_name . ') complete draft', 0);
        LogActivity::addToLog("Complete draft", $certificate);
        $this->userNotificationsRepositary->makeNotification(
            $client->environmentOfficer->user_id,
            'Certificate Drafted for "' . $client->industry_name . '"',
            $certificate->client_id
        );
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
        fileLog($certificate->client_id, 'certificate', 'User (' . $user->user_name . ') complete certificate', 0);
        LogActivity::addToLog("Complete certificate", $certificate);
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

            $responses = Certificate::With(['Client.pradesheeyasaba', 'Client.warningLetters'])->selectRaw('max(id) as id, client_id, expire_date,cetificate_number,certificate_type')
                ->whereHas('Client.environmentOfficer.assistantDirector', function ($query) use ($id) {
                    $query->where('assistant_directors.id', '=', $id);
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
            $responses = Certificate::With(['Client.pradesheeyasaba', 'Client.warningLetters'])->selectRaw('max(id) as id, client_id, expire_date,cetificate_number, certificate_type')
                ->where('expire_date', '<', $date)
                ->where('certificate_type', '=', 0)
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

    public function getCofirmedFiles()
    { //to all get all active files
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $client = Client::where('is_old', 2)->get();
        return $client;
    }

    public function get_file_cordinates($industry_cat_id, $eo_id)
    {
        $file_cords = \DB::table('clients')
            ->select('clients.industry_coordinate_x', 'clients.industry_coordinate_y', 'clients.file_no')
            ->where('clients.environment_officer_id', '=', $eo_id)
            ->where('clients.industry_category_id', '=', $industry_cat_id)
            ->get()->toArray();
        //                ->toSql();
        //        dd($file_cords);
        $locations = collect($file_cords)->map(function ($name) {
            return array($name->file_no, $name->industry_coordinate_x, $name->industry_coordinate_y);
        });
        // dd($file_cords);
        return $locations;
    }

    //    public function getConfirmedClients() {
    //        $clients = Client::where('deleted_at', '=', null)->where('is_old', '!=', 0)->get();
    //        return $clients;
    //    }
    //    public function showListOfRegistrations() {
    //        $search_txt = '';
    ////        $filter_main_payment_category_id = $this->input->post_get('main_payment_category_id');
    //        $this - > db - > select('user_tbl_id', false);
    //        $this - > db - > from('user_registrations');
    //        $this - > db - > join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = user_registrations.user_member_class', 'left');
    //        $this - > db - > join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = user_registrations.user_member_discipline', 'left');
    //
    //        if (!empty($search['value'])) {
    //            $this - >db - > group_start();
    //            $this - > db - > like('reg_application_id', $search['value'], 'both');
    //            $this - > db - > or_like('user_name_w_initials', $search['value'], 'both');
    //            $this - > db - > or_like('user_nic', $search['value'], 'both');
    //            $this - > db - > group_end();
    //            $search_txt = $search['value'];
    //        }
    //
    //        $result = FALSE;
    //        $totalData = $this - > db - > count_all_results();
    //        $totalFiltered = $totalData;
    //        $data_result = array();
    //        $q = '';
    //        if (!empty($totalData)) {
    //            $columns = array(
    //                'reg_application_id',
    //                'class_of_membership_name',
    //                'core_engineering_discipline_name',
    //                'user_picture',
    //                'user_name_w_initials',
    //                'user_nic',
    //                'applied_date',
    //                'final_approval'
    //            );
    //
    //            $search = $this - > input - > post_get('search');
    //            $order = $this - > input - > post_get('order');
    //            $start = $this - > input - > post_get('start');
    //            $limit = $this - > input - > post_get('length');
    //
    //            $this - > db - > select(implode(",", array(
    //                'reg_application_id',
    //                'class_of_membership_name',
    //                'core_engineering_discipline_name',
    //                'user_picture',
    //                'user_name_w_initials',
    //                'user_nic',
    //                'DATE(user_registrations.created_datetime) AS applied_date',
    //                'user_tbl_id',
    //                'final_approval'
    //                    )), false);
    //            $this - > db - > from('user_registrations');
    //            $this - > db - > join('master_classes_of_membership', 'master_classes_of_membership.class_of_membership_id = user_registrations.user_member_class', 'left');
    //            $this - > db - > join('master_core_engineering_disciplines', 'master_core_engineering_disciplines.core_engineering_discipline_id = user_registrations.user_member_discipline', 'left');
    //            if (!empty($search['value'])) {
    //                $this - > db - > group_start();
    //                $this - > db - > like('reg_application_id', $search['value'], 'both');
    //                $this - > db - > or_like('user_name_w_initials', $search['value'], 'both');
    //                $this - > db - > or_like('user_nic', $search['value'], 'both');
    //                $this - > db - > group_end();
    //            }
    //            $this - > db - > order_by($columns[$order[0]['column']], $order[0]['dir']);
    //            if (!empty($limit)) {
    //                $this - > db - > limit($limit, $start);
    //            }
    //            $query = $this - > db - > get();
    //            if (empty($query)) {
    //                return false;
    //            } else {
    //                $data_result = $query - > result();
    //            }
    //            if (!empty($search['value'])) {
    //                $totalFiltered = $query - > num_rows();
    //            }
    //        }
    //        $json_data = array(
    //        "draw" => intval($this- > input - > post_get('draw')), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    //        "recordsTotal" => intval($totalData), // total number of records
    //        "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    //        "data" => $data_result // total data array
    //        );
    //
    //        return $json_data;
    //    }
    //    public function server_side_process_two(Request $request) {
    //        //only sorts by one column
    ////        $orderby = $request->input('order_column');
    ////        $sort['col'] = $request->input('columns.' . $orderby . '.data');
    ////        $sort['dir'] = $request->input('order_dir');
    //
    //        $query = Client::where('file_no', 'like', '%' . $request->input('search.value') . '%')
    //                ->where('deleted_at', '=', null)
    //                ->where('is_old', '!=', 0)
    //                ->orWhere('first_name', 'like', '%' . $request->input('search.value') . '%')
    //                ->orWhere('industry_name', 'like', '%' . $request->input('search.value') . '%');
    //
    //        $output['recordsTotal'] = $query->count();
    //
    //        $output['data'] = $query
    ////                ->orderBy($sort['col'], $sort['dir'])
    //                ->skip($request->input('start'))
    //                ->take($request->input('length', 10))
    //                ->get();
    //
    //        $output['recordsFiltered'] = $output['recordsTotal'];
    //
    //        $output['draw'] = intval($request->input('draw'));
    //        return $output;
    //    }

    public function server_side_process(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'file_no',
            2 => 'first_name',
            3 => 'industry_name',
            4 => 'industry_registration_no',
        );
        $totalData = Client::where('deleted_at', '=', null)->where('is_old', '!=', 0)->count();

        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $clients = Client::where('is_old', '!=', 0)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $clients = Client::where('is_old', '!=', 0)
                //                    ->orWhere('id', 'LIKE', "%{$search}%")
                ->Where('file_no', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('industry_registration_no', 'LIKE', "%{$search}%")
                ->orWhere('industry_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
            //dd($clients);
            $totalFiltered = Client::where('is_old', '!=', 0)
                //                    ->orWhere('id', 'LIKE', "%{$search}%")
                ->Where('file_no', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('industry_registration_no', 'LIKE', "%{$search}%")
                ->orWhere('industry_name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        if (!empty($clients)) {
            //            print_r($clients);
            //            exit;
            foreach ($clients as $client) {
                //                $show =  route('posts.show',$post->id);
                //                $edit =  route('posts.edit',$post->id);
                $nestedData['id'] = $client->id;
                $nestedData['file_no'] = $client->file_no;
                $nestedData['client_name'] = $client->first_name . $client->last_name;
                $nestedData['industry_name'] = $client->industry_name;
                $nestedData['industry_registration_no'] = $client->industry_registration_no;
                //                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
                //                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                //                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                //                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function eo_client_data(Request $request)
    {
        $prs = $request->pradeshiya_sabha;
        $ind_cat = $request->industry_category;
        $prs_check = $request->pradeshiya_sabha_check;
        $ind_cat_check = $request->industry_category_check;
        $client_data = null;

        if ($prs_check == 'on' && $ind_cat_check != 'on') {
            $client_data = Client::where('pradesheeyasaba_id', '=', $prs)
                ->join('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
                ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
                ->get();
        }
        if ($prs_check != 'on' && $ind_cat_check == 'on') {
            $client_data = Client::leftjoin('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
                ->leftjoin('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
                ->where('industry_category_id', '=', $ind_cat)
                ->get();
        }
        if ($prs_check == 'on' && $ind_cat_check == 'on') {
            $client_data = Client::where('pradesheeyasaba_id', '=', $prs)
                ->Where('industry_category_id', '=', $ind_cat)
                ->join('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
                ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
                ->get();
        }
        return $client_data;
    }
}
