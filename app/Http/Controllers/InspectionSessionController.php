<?php

namespace App\Http\Controllers;



use Carbon\Carbon;
use App\EPL;
use App\Client;
use App\ApplicationType;
use App\InspectionDateLog;
use App\InspectionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;
use App\inspection_interviewers;
use App\InspectionPersonal;
use App\InspectionSessionAttachment;

class InspectionSessionController extends Controller
{

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
            $EPL = EPL::find($id);
            if ($EPL !== null) {
                return view('epl_inspection_session', ['pageAuth' => $pageAuth, 'id' => $id, "epl_number" => $EPL->code, "client" => $EPL->client_id, "epl_id" => $EPL->id]);
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
    public function createInspection($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'schedule_date' => 'required|date',
                'remark' => ['sometimes', 'nullable', 'string'],
                'environment_officer_id' => 'required|integer',
            ]);
            $file = Client::find($id);
            if ($file) {
                $inspectionSession = new InspectionSession();
                $autoData = $this->getAutomaticInspectionPlacementData($id);
                $inspectionSession->application_type = $autoData['type'];
                $inspectionSession->profile_id = $autoData['id'];
                $inspectionSession->client_id = $file->id;
                $inspectionSession->schedule_date = request('schedule_date');
                $inspectionSession->remark = request('remark');
                $inspectionSession->environment_officer_id = request('environment_officer_id');
                $msg = $inspectionSession->save();

                $dLog = new InspectionDateLog();
                $dLog->date = request('schedule_date');
                $dLog->inspection_session_id = $inspectionSession->id;
                $msg = $msg &&  $dLog->save();

                $file->need_inspection = Client::STATUS_PENDING;
                $msg = $msg && $file->save();


                if ($msg) {
                    LogActivity::addToLog('Inspection Session Created', $inspectionSession);
                    LogActivity::fileLog($inspectionSession->client_id, 'Inspection', $user->last_name . " Add inspection", 1, 'inspection', '');
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

    private function getAutomaticInspectionPlacementData($id)
    {
        $client = Client::findOrfail($id);
        $epls = $client->epls;
        $siteClearance = $client->siteClearenceSessions;
        $cer_type_status = $client->cer_type_status;
        if ($cer_type_status == 0) {
            abort(422, 'Add EPL or Site Clearance to the file before schedule a inspection');
        }

        if ($cer_type_status == 1 || $cer_type_status == 2) {
            return array('type' => InspectionSession::TYPE_EPL, 'id' => $epls[0]->id);
        } else if ($cer_type_status == 3 || $cer_type_status == 4) {
            return array('type' => InspectionSession::SITE_CLEARANCE, 'id' => $siteClearance[0]->id);
        } else {
            abort(422, 'Can not resolve whether file belong to a inspection or a site clearance. No epls or site clearances found');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function showInspections($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $client = Client::findOrFail($id);
        return InspectionSession::with('inspectionRemarks')->with('inspectionSessionAttachments')->with('inspectionPersonals')->where('client_id', $client->id)->get();
    }

    public function showInspectionsByDate($date, $id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return InspectionSession::with('inspectionRemarks')
            ->with('inspectionSessionAttachments')
            ->with('inspectionPersonals')
            ->with('client')
            ->whereDate('schedule_date', $date)
            ->whereHas('client', function ($sql) use ($id) {
                return $sql->where('clients.environment_officer_id', '=', $id);
            })
            ->where('status', 0)
            ->get();
    }

    public function showInspectionsPending($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $client = Client::findOrFail($id);
        return InspectionSession::with('inspectionRemarks')
            ->with('inspectionSessionAttachments')
            ->with('inspectionPersonals')
            ->where('client_id', $client->id)
            ->where('status', 0)
            ->get();
    }

    public function showInspectionsCompleted($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $client = Client::findOrFail($id);
        return InspectionSession::with('inspectionRemarks')
            ->with('inspectionSessionAttachments')
            ->with('inspectionPersonals')
            ->where('client_id', $client->id)
            ->where('status', 1)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function destroyInspection($sessionId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $inspectionSession = InspectionSession::findOrFail($sessionId);
            $file = $inspectionSession->client;
            $msg = $inspectionSession->delete();
            $file->need_inspection = Client::STATUS_INSPECTION_NEEDED;
            $msg = $msg && $file->save();


            if ($msg) {
                LogActivity::addToLog('Inspection Session Deleted', $inspectionSession);
                LogActivity::fileLog($inspectionSession->client_id, 'Inspection', $user->last_name . "cancel inspection", 1, 'inspection', '');
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function find($sessionId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));

        return InspectionSession::with('inspectionRemarks')
            ->with('inspectionSessionAttachments')
            ->with('inspectionPersonals')
            ->findOrFail($sessionId);
    }

    public function markComplete($sessionId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));

        $inspectionSession = InspectionSession::findOrFail($sessionId);
        $inspectionSession->completed_at = Carbon::now()->format('Y-m-d H:i:s');
        $inspectionSession->status = 1;
        $msg = $inspectionSession->save();
        $file = $inspectionSession->client;
        $file->need_inspection = Client::STATUS_COMPLETED;
        $msg = $msg && $file->save();


        if ($msg) {
            LogActivity::addToLog('Inspection Session Mark as complete', $inspectionSession);
            LogActivity::fileLog($inspectionSession->client_id, 'Inspection', $user->last_name . " Complete inspection", 1, 'inspection', '');
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function markPending($sessionId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));

        $inspectionSession = InspectionSession::findOrFail($sessionId);
        $inspectionSession->status = 0;
        $msg = $inspectionSession->save();
        $file = $inspectionSession->client;
        $file->need_inspection = Client::STATUS_COMPLETED;
        $msg = $msg && $file->save();

        if ($msg) {
            LogActivity::addToLog('Inspection Session Mark as pending', $inspectionSession);
            LogActivity::fileLog($inspectionSession->client_id, 'Inspection', $user->last_name . " Add inspection to pending", 1, 'inspection', '');
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function updateMobileInspection(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
            'remarks' => 'nullable',
            'inspection_attachments' => 'nullable|array',
            'sketch_file' => 'required|mimes:jpeg,jpg,png',
            'inspectionInterviewers' => 'nullable',
            'inspectionPersonals' => 'nullable',
            'proposed_land_ext' => 'nullable',
            'project_area_type' => 'nullable',
            'land_use' => 'nullable',
            'house_within_100' => 'nullable',
            'ownersip' => 'nullable',
            'adj_land_n' => 'nullable',
            'adj_land_s' => 'nullable',
            'adj_land_e' => 'nullable',
            'adj_land_w' => 'nullable',
            'sensitive_area_desc' => 'nullable',
            'special_issue_desc' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);
        // dd($request->all());
        $inspectionSession = InspectionSession::findOrFail($request->session_id);
        if (!empty($request->latitude) && !empty($request->longitude)) {
            $client = Client::findOrFail($inspectionSession->client_id);
            $client->industry_coordinate_x = $request->latitude;
            $client->industry_coordinate_y = $request->longitude;
            $client->save();
        }
        $inspectionSession->remark = $request->remark;
        $inspectionSession->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $inspectionInterviewers = $request->inspectionInterviewers;
        $InspectionPersonals = $request->inspectionPersonals;

        if (($request->hasFile('sketch_file'))) {
            $sketchPath = $request->file('sketch_file')->store('uploads/industry_files/' . $inspectionSession->client_id . '/inspections/' . $inspectionSession->id);
            $inspectionSession->sketch_path = $sketchPath;
        }

        $inspectionSession->proposed_land_ext = $request->proposed_land_ext;
        $inspectionSession->project_area_type = $request->project_area_type;
        $inspectionSession->land_use = $request->land_use;
        $inspectionSession->house_within_100 = $request->house_within_100;
        $inspectionSession->ownersip = $request->ownersip;
        $inspectionSession->adj_land_n = $request->adj_land_n;
        $inspectionSession->adj_land_s = $request->adj_land_s;
        $inspectionSession->adj_land_e = $request->adj_land_e;
        $inspectionSession->adj_land_w = $request->adj_land_w;
        $inspectionSession->sensitive_area_desc = $request->sensitive_area_desc;
        $inspectionSession->special_issue_desc = $request->special_issue_desc;
        $inspectionSession->save();

        if ($request->hasFile('inspection_attachments')) {
            $InspectionAttathments = $request->file('inspection_attachments');
            foreach ($InspectionAttathments as $attachment) {
                $type = $attachment->extension();
                $inspectionSessionAttachment = new InspectionSessionAttachment();
                $inspectionSessionAttachment->inspection_session_id = $request->session_id;
                $attachmentPath = $attachment->store('uploads/industry_files/' . $inspectionSession->client_id . '/inspections/' . $inspectionSession->id);
                if ($attachmentPath) {
                    $inspectionSessionAttachment->path = $attachmentPath;
                    $inspectionSessionAttachment->type = $type;
                    $inspectionSessionAttachment->save();
                }
            }
        }

        if (!empty($inspectionInterviewers)) {
            $inspectionInterviewers = explode(',', $inspectionInterviewers);
            foreach ($inspectionInterviewers as $inspectionInterviewer) {
                $inspectionInterviewer = new inspection_interviewers();
                $inspectionInterviewer->inspection_session_id = $request->session_id;
                $inspectionInterviewer->name = $inspectionInterviewer;
            }
        }

        if (!empty($InspectionPersonals)) {
            $InspectionPersonals = explode(',', $InspectionPersonals);
            foreach ($InspectionPersonals as $inspectionPersonal) {
                $inspectionPersonal = new InspectionPersonal();
                $inspectionPersonal->inspection_session_id = $request->session_id;
                $inspectionPersonal->name = $inspectionPersonal;
            }
        }
        return array('id' => 1, 'message' => 'true');
    }
}
