<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Client;
use App\ApplicationType;
use App\InspectionDateLog;
use App\InspectionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                $msg = $inspectionSession->save();

                $dLog = new InspectionDateLog();
                $dLog->date = request('schedule_date');
                $dLog->inspection_session_id = $inspectionSession->id;
                $msg = $msg &&  $dLog->save();

                $file->need_inspection = Client::STATUS_PENDING;
                $file->is_working = Client::IS_WORKING_WORKING;
                $msg = $msg && $file->save();
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

    private function getAutomaticInspectionPlacementData($id)
    {
        $client = Client::findOrfail($id);
        $epls = $client->epls;
        $siteClearance = $client->siteClearenceSessions;
        // dd(count($epls));
        if (count($epls) > 0 && count($siteClearance) > 0) {
            return response(array('id' => 0, 'message' => 'Can not resolve whether file belong to a inspection or a site clearance'), 422);
        }
        if (count($epls) > 1 && $siteClearance($siteClearance) > 1) {
            return response(array('id' => 0, 'message' => 'Can not resolve whether file belong to a inspection or a site clearance. more than one epls or site clearances found'), 422);
        }

        if (count($epls) > 0) {
            return array('type' => InspectionSession::TYPE_EPL, 'id' => $epls[0]->id);
        } else if ($siteClearance($siteClearance) > 0) {
            return array('type' => InspectionSession::SITE_CLEARANCE, 'id' => $siteClearance[0]->id);
        } else {
            return response(array('id' => 0, 'message' => 'Can not resolve whether file belong to a inspection or a site clearance. No epls or site clearances found'), 422);
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
            ->where('schedule_date', $date)
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionSession $inspectionSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionSession $inspectionSession)
    {
        //
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
            $file->is_working = Client::IS_WORKING_WORKING;
            $msg = $msg && $file->save();
            if ($msg) {
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
        $inspectionSession->status = 1;
        $msg = $inspectionSession->save();
        $file = $inspectionSession->client;
        $file->need_inspection = Client::STATUS_COMPLETED;
        $msg = $msg && $file->save();
        if ($msg) {
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
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }
}
