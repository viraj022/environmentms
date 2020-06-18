<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\EPL;
use App\InspectionDateLog;
use App\InspectionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionSessionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (EPL::find($id) !== null) {
                return view('epl_inspection_session', ['pageAuth' => $pageAuth, 'id' => $id]);
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
    public function createEplInspection($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'schedule_date' => 'required|date',
                'remark' => ['sometimes', 'nullable', 'string'],
            ]);
            $epl = EPL::find($id);
            if ($epl) {
                $inspectionSession = new InspectionSession();
                $inspectionSession->application_type_id = ApplicationType::getByName(ApplicationTypeController::EPL)->id;
                $inspectionSession->profile_id = $epl->id;
                $inspectionSession->schedule_date = request('schedule_date');
                $inspectionSession->remark = request('remark');

                $msg = $inspectionSession->save();
                $dLog = new InspectionDateLog();
                $dLog->date = request('schedule_date');
                $dLog->inspection_session_id = $inspectionSession->id;
                $dLog->save();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function showEPLInspections($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
      
          
            $epl = EPL::find($id);
            if ($epl) {
               return InspectionSession::where('profile_id',$id)->get();
            } else {
                abort(404);
            }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionSession $inspectionSession) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionSession $inspectionSession) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionSession  $inspectionSession
     * @return \Illuminate\Http\Response
     */
    public function destroyEplInspection($sessionId) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $inspectionSession = InspectionSession::findOrFail($sessionId);
            $msg = $inspectionSession->delete();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }
    public function find($sessionId) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
      
            $inspectionSession = InspectionSession::findOrFail($sessionId);
            $msg = $inspectionSession->find($sessionId);
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
       
    }

}
