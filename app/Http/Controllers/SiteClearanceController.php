<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Client;
use Carbon\Carbon;
use App\BusinessScale;
use App\SiteClearance;
use App\Pradesheeyasaba;
use App\IndustryCategory;
use App\Helpers\LogActivity;
use App\Setting;
use Illuminate\Http\Request;
use App\SiteClearenceSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SiteClearanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($client, $profile)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (Client::find($client) !== null && SiteClearenceSession::find($profile) !== null) {
                return view('site_clearance', ['pageAuth' => $pageAuth, 'client' => $client, 'profile' => $profile, 'code' => SiteClearenceSession::find($profile)->code]);
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
            'code' => 'required|string',
            'remark' => 'nullable|string',
            'type' => ["required", "regex:(" . SiteClearance::SITE_CLEARANCE . "|" . SiteClearance::SITE_TELECOMMUNICATION . "|" . SiteClearance::SITE_SCHEDULE_WASTE . ")"],
            'issue_date' => 'required|date',
            'expire_date' => 'required|date',
            'submit_date' => 'required|date',
            'count' => 'required|integer',
            'file' => 'required|mimes:jpeg,jpg,png,pdf'
        ]);
        // save site clearance session  
        return \DB::transaction(function () use ($id, $request) {
            $client = Client::findOrFail($id);
            $siteSessions = $client->siteClearenceSessions;
            if (count($siteSessions) > 0) { // checking for a already existing record
                return response(array("id" => 2, "message" => 'Record Already Exist Please Update the existing record'), 403);
            }
            //            $client->is_working = 1;
            $msg = $client->save();
            $siteSessions = new SiteClearenceSession();
            $siteSessions->client_id = $client->id;
            $siteSessions->code = \request('code');
            $siteSessions->remark = \request('remark');
            $siteSessions->site_clearance_type = \request('type');
            $msg = $siteSessions->save();
            // saving site site clearance data
            $siteClearance = new SiteClearance();
            $siteClearance->submit_date = \request('submit_date');
            $siteClearance->issue_date = \request('issue_date');
            $siteClearance->expire_date = \request('expire_date');
            $siteClearance->count = \request('count');
            $siteClearance->site_clearence_session_id = $siteSessions->id;
            $msg = $msg && $siteClearance->save();
            LogActivity::fileLog($client->id, 'SiteClear', "Save old data :SiteClearanceController", 1);
            // save old data file
            if ($msg) {
                if ($request->file('file') != null) {
                    $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                    $fileUrl = '/uploads/' . FieUploadController::getSiteClearanceCertificateFilePath($siteSessions);
                    $storePath = 'public' . $fileUrl;
                    $path = $request->file('file')->storeAs($storePath, $file_name);
                    $siteClearance->certificate_path = "storage/" . $fileUrl . "/" . $file_name;
                    $msg = $msg && $siteClearance->save();
                } else {
                    return response(array('id' => 1, 'message' => 'certificate not found'), 422);
                }
            } else {
                abort(500);
            }
            // sending response
            if ($msg) {
                LogActivity::addToLog('saveOldData : SiteClearanceController', $client);
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('saveOldData Fail : SiteClearanceController', $client);
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function updateOldData($id, Request $request)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        // validations 
        request()->validate([
            'code' => 'required|string',
            'remark' => 'nullable|string',
            'issue_date' => 'required|date',
            'expire_date' => 'required|date',
            'submit_date' => 'required|date',
            'count' => 'required|integer',
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf'
        ]);
        // save epl main file      
        return \DB::transaction(function () use ($id, $request) {
            $msg = true;

            // update site session data
            $siteClearanceSession = SiteClearenceSession::findOrFail($id);
            $siteClearanceSession->code = \request('code');
            $siteClearanceSession->remark = \request('remark');
            $msg = $siteClearanceSession->save();
            // save site data
            $siteClearance = SiteClearance::findOrFail($siteClearanceSession->siteClearances[0]->id);
            $siteClearance->submit_date = \request('submit_date');
            $siteClearance->issue_date = \request('issue_date');
            $siteClearance->expire_date = \request('expire_date');
            $siteClearance->count = \request('count');
            $msg = $msg && $siteClearance->save();
            // save old data file
            if ($msg) {
                if ($request->file('file') != null) {
                    $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                    $fileUrl = '/uploads/' . FieUploadController::getSiteClearanceCertificateFilePath($siteClearanceSession);
                    $storePath = 'public' . $fileUrl;
                    $path = $request->file('file')->storeAs($storePath, $file_name);
                    $siteClearance->certificate_path = "storage/" . $fileUrl . "/" . $file_name;
                }
                $msg = $msg && $siteClearance->save();
            } else {
                abort(500);
            }
            // sending response
            if ($msg) {
                LogActivity::addToLog('updateOldData done : SiteClearanceController', $siteClearance);
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('updateOldData Fail : SiteClearanceController', $siteClearance);
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function deleteOldData($id)
    {
        return \DB::transaction(function () use ($id) {
            $siteClearanceSession = SiteClearenceSession::findOrFail($id);
            $msg = $siteClearanceSession->delete();
            $siteClearance = SiteClearance::findOrFail($siteClearanceSession->siteClearances[0]->id);
            $msg = $msg && $siteClearance->delete();
            if ($msg) {
                LogActivity::addToLog('deleteOldData done : SiteClearanceController', $siteClearance);
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('deleteOldData Fail : SiteClearanceController', $siteClearance);
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function extendSiteClearence(Request $request, SiteClearenceSession $siteClearanceSession)
    {
        // return \DB::transaction(function () use ($request, $client) {
        //     if ($msg) {
        //         LogActivity::addToLog('deleteOldData done : SiteClearanceController', $siteClearance);
        //         return array('id' => 1, 'message' => 'true');
        //     } else {
        //         LogActivity::addToLog('deleteOldData Fail : SiteClearanceController', $siteClearance);
        //         return array('id' => 0, 'message' => 'false');
        //     }
        // });
    }

    public function create(Request $request)
    {
        return DB::transaction(function () use ($request) {
            request()->validate([
                'remark' => 'nullable|string',
                'type' => ["required", "regex:(" . SiteClearance::SITE_CLEARANCE . "|" . SiteClearance::SITE_TELECOMMUNICATION . "|" . SiteClearance::SITE_SCHEDULE_WASTE . ")"],
                'submit_date' => 'required|date',
                'client_id' => 'required|integer',
                'file' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);
            // save site clearance session
            $siteSessions = new SiteClearenceSession();
            $siteSessions->client_id = $request->client_id;
            $siteSessions->code = $this->generateCode($request->client_id);
            $siteSessions->remark = $request->remark;
            $siteSessions->site_clearance_type = $request->type;
            $msg = $siteSessions->save();

            //  save site clearance
            $siteClearance = new SiteClearance();
            $siteClearance->submit_date = $request->submit_date;
            $siteClearance->site_clearence_session_id = $siteSessions->id;
            $siteClearance->count = 1;
            // upload file
            if ($request->file('file') != null) {
                $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                $fileUrl = '/uploads/industry_files/' . $siteSessions->client_id . '/site_clearance/application/' . $siteSessions->id;
                $storePath = 'public' . $fileUrl;
                $path = $request->file('file')->storeAs($storePath, $file_name);
                $siteClearance->application_path = "storage" . $fileUrl . "/" . $file_name;
                $msg = $msg && $siteClearance->save();
            } else {
                return response(array('id' => 1, 'message' => 'certificate not found'), 422);
            }
            /**
             * increment serial number
             */
            incrementSerial(Setting::EPL_AI);
            // change file status        
            setFileStatus($siteSessions->client_id, 'file_status', 0);  // set file status to zero 
            setFileStatus($siteSessions->client_id, 'inspection', null);  //  set inspection pending status to 'null'
            setFileStatus($siteSessions->client_id, 'cer_type_status', 3);  // set inspection pending status to 3
            setFileStatus($siteSessions->client_id, 'cer_status', 0);  // set certificate status to 0
            setFileStatus($siteSessions->client_id, 'file_problem', 0); // set file problem status to 0
            // $file = #ssiteClearenceSession->client;
            LogActivity::addToLog('create new site clearance ', $siteSessions);
            if ($siteSessions) {
                return response(array("id" => 1, "message" => "ok", 'rout' => "/site_clearance/client/" . $siteSessions->client_id . "/profile/" . $siteSessions->id));
            } else {
                return response(array("id" => 0, "message" => "fail"));
            }
        });
    }

    public function find($id)
    {
        return SiteClearenceSession::with('siteClearances')->with('client.environmentOfficer')->findOrFail($id);
    }

    private function generateCode($client)
    {

        $client = Client::findOrFail($client);
        if ($client->cer_type_status == 3) {
            /**
             * For Site Clearence
             */
            $la = Pradesheeyasaba::find($client->pradesheeyasaba_id);
            $lsCOde = $la->code;
            $industry = IndustryCategory::find($client->industry_category_id);
            $industryCode = $industry->code;
            $scale = BusinessScale::find($client->business_scale_id);
            $scaleCode = $scale->code;
            $e = SiteClearenceSession::orderBy('id', 'desc')->first();
            $serial = getSerialNumber(Setting::SITE_AI);
            $serial = sprintf('%02d', $serial);
            return "PEA/" . $lsCOde . "/SC/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
        } else {
            /**
             * when file is in other status than new epl or epl renewal
             */
            abort(501, 'Invalid certificate type statues (3) - hcw error code');
        }
    }

    public function setProcessingStatus(Request $request, SiteClearenceSession $siteClearanceSession)
    {
        request()->validate([
            'status' => 'required|integer|between:0,3',
        ]);
        // dd($siteClearanceSession);
        $siteClearanceSession->processing_status = $request->status;
        if ($siteClearanceSession->save()) {
            return response(array("id" => 1, "message" => "ok"));
        } else {
            return response(array("id" => 0, "message" => "fail"));
        }
    }

    public function uploadTor(Request $request, SiteClearenceSession $siteClearenceSession)
    {
        // return $siteClearenceSession;

        request()->validate([
            'expire_date' => 'required|date',
            'valid_date' => 'required|date',
            'file' => 'required|mimes:jpeg,jpg,png,pdf',
        ]);
        if ($request->file('file') != null) {
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = '/uploads/' . FieUploadController::torPath($siteClearenceSession);
            $storePath = 'public' . $fileUrl;
            $path = $request->file('file')->storeAs($storePath, $file_name);
            $db_path = "storage" . $fileUrl . "/" . $file_name;
            if ($siteClearenceSession->content_paths) {
                $siteClearenceSession->content_paths = array_merge($siteClearenceSession->content_paths, ["tor" => ["path" => $db_path, "expire_date" => $request->expire_date, "valid_date" => $request->valid_date]]);
            } else {
                $siteClearenceSession->content_paths = ["tor" => ["path" => $db_path, "expire_date" => $request->expire_date, "valid_date" => $request->valid_date]];
            }
            if ($siteClearenceSession->save()) {
                return response(array("id" => 1, "message" => "ok"));
            } else {
                return response(array("id" => 0, "message" => "fail"));
            }
        } else {
            abort(422, "FIle Not Found");
        }
    }

    public function clientReport(Request $request, SiteClearenceSession $siteClearenceSession)
    {
        // return $siteClearenceSession;

        request()->validate([
            'expire_date' => 'required|date',
            'file' => 'required|mimes:jpeg,jpg,png,pdf',
        ]);
        if ($request->file('file') != null) {
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = '/uploads/' . FieUploadController::torPath($siteClearenceSession);
            $storePath = 'public' . $fileUrl;
            $path = $request->file('file')->storeAs($storePath, $file_name);
            $db_path = "storage" . $fileUrl . "/" . $file_name;
            if ($siteClearenceSession->content_paths) {
                $siteClearenceSession->content_paths = array_merge($siteClearenceSession->content_paths, ["client_report" => ["path" => $db_path, "expire_date" => $request->expire_date]]);
            } else {
                $siteClearenceSession->content_paths = ["client_report" => ["path" => $db_path, "expire_date" => $request->expire_date]];
            }

            if ($siteClearenceSession->save()) {
                return response(array("id" => 1, "message" => "ok"));
            } else {
                return response(array("id" => 0, "message" => "fail"));
            }
        } else {
            abort(422, "FIle Not Found");
        }
    }
}
