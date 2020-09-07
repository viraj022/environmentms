<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use App\SiteClearance;
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
    public function index()
    {
        //
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
            $client->is_working = 1;
            $msg = $client->save();
            $siteSessions = new SiteClearenceSession();
            $siteSessions->client_id = $client->id;
            $siteSessions->code = \request('code');
            $siteSessions->remark = \request('remark');
            $siteSessions->site_clearance_type = \request('type');
            $msg =  $siteSessions->save();
            // saving site site clearance data
            $siteClearance =  new SiteClearance();
            $siteClearance->submit_date = \request('submit_date');
            $siteClearance->issue_date = \request('issue_date');
            $siteClearance->expire_date = \request('expire_date');
            $siteClearance->count = \request('count');
            $siteClearance->site_clearence_session_id = $siteSessions->id;
            $msg = $msg && $siteClearance->save();
            // save old data file
            if ($msg) {
                if ($request->file('file') != null) {
                    $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                    $fileUrl = '/uploads/industry_files/' . $client->id . '/site_clearance/' . $siteSessions->id;
                    $storePath = 'public' . $fileUrl;
                    $path = $request->file('file')->storeAs($storePath, $file_name);
                    $siteClearance->certificate_path =  "storage/" . $fileUrl . "/" . $file_name;
                    $msg = $msg && $siteClearance->save();
                } else {
                    return response(array('id' => 1, 'message' => 'certificate not found'), 422);
                }
            } else {
                abort(500);
            }
            // sending response
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
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
            $msg =  $siteClearanceSession->save();
            // save site data
            $siteClearance = SiteClearance::findOrFail($siteClearanceSession->siteClearances[0]->id);
            $siteClearance->submit_date = \request('submit_date');
            $siteClearance->issue_date = \request('issue_date');
            $siteClearance->expire_date = \request('expire_date');
            $siteClearance->count = \request('count');
            $msg = $msg &&  $siteClearance->save();
            // save old data file
            if ($msg) {
                if ($request->file('file') != null) {
                    $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                    $fileUrl = '/uploads/industry_files/' . $siteClearanceSession->client_id . '/site_clearance/' . $siteClearanceSession->id;
                    $storePath = 'public' . $fileUrl;
                    $path = $request->file('file')->storeAs($storePath, $file_name);
                    $siteClearance->certificate_path =  "storage/" . $fileUrl . "/" . $file_name;
                }
                $msg = $msg &&  $siteClearance->save();
            } else {
                abort(500);
            }
            // sending response
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }


    public function deleteOldData($id)
    {
        return \DB::transaction(function () use ($id) {
            $siteClearanceSession = SiteClearenceSession::findOrFail($id);
            $msg =  $siteClearanceSession->delete();
            $siteClearance = SiteClearance::findOrFail($siteClearanceSession->siteClearances[0]->id);
            $msg = $msg && $siteClearance->delete();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }
}
