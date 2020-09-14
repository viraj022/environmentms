<?php

namespace App\Http\Controllers;

use App\EPL;
use Carbon\Carbon;
use App\ApprovalLog;
use App\EnvironmentOfficer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class ApprovalLogController extends Controller
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
            $epl = EPL::find($id);
            //            dd($epl);
            if ($epl !== null) {
                return view('certificate_approval', ['pageAuth' => $pageAuth, 'id' => $id, 'client_id' => $epl->client_id, 'epl_code' => $epl->code, 'level' => $user->roll->level]);
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
    public function approveOfficer($eplId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'date' => 'required|date',
                'comment' => 'required|string'
            ]);
            $epl = EPL::find($eplId);
            // dd($epl);
            if ($epl) {
                if ($epl->client->environment_officer_id != null) {
                    $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                        ->where('type_id', $epl->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($abc) {

                        if ($abc->officer_type == ApprovalLog::OFF_OFFICER && $abc->status == ApprovalLog::APP_APPROVE) {
                            return response(array('id' => 0, 'message' => 'Already Rejected'), 422);
                        }
                    }
                    $approvalLog = new ApprovalLog();
                    $approvalLog->type = ApprovalLog::Type_EPL;
                    $approvalLog->type_id = $epl->id;
                    $approvalLog->officer_type = ApprovalLog::OFF_OFFICER;
                    $approvalLog->user_id = $epl->environment_officer_id;
                    $approvalLog->comment = request('comment');
                    $approvalLog->status = ApprovalLog::APP_APPROVE;
                    $approvalLog->approve_date = Carbon::now()->toDateTimeString();
                    $msg = $approvalLog->save();
     
                    if ($msg) {
                        LogActivity::addToLog('approveOfficer done : ApprovalLogController',$approvalLog);            
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        LogActivity::addToLog('approveOfficer Fail : ApprovalLogController',$approvalLog);
                        return array('id' => 0, 'message' => 'false');
                    }


                } else {
                    return response(array('id' => 0, 'message' => 'Environment Officer Not Found'), 404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function rejectOfficer($eplId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'date' => 'required|date',
                'comment' => 'required|string'
            ]);
            $epl = EPL::find($eplId);
            if ($epl) {
                if ($epl->client->environment_officer_id != null) {
                    $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                        ->where('type_id', $epl->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($abc->officer_type == ApprovalLog::OFF_OFFICER && $abc->status == ApprovalLog::APP_REJECT) {
                        return response(array('id' => 0, 'message' => 'Already Rejected'), 422);
                    }
                    $approvalLog = new ApprovalLog();
                    $approvalLog->type = ApprovalLog::Type_EPL;
                    $approvalLog->type_id = $epl->id;
                    $approvalLog->officer_type = ApprovalLog::OFF_OFFICER;
                    $approvalLog->user_id = $epl->environment_officer_id;
                    $approvalLog->comment = request('comment');
                    $approvalLog->status = ApprovalLog::APP_REJECT;
                    $approvalLog->approve_date = Carbon::now()->toDateTimeString();
                    $msg = $approvalLog->save();
           
                    if ($msg) {
                        LogActivity::addToLog('rejectOfficer done : ApprovalLogController',$approvalLog);            
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        LogActivity::addToLog('rejectOfficer Fail : ApprovalLogController',$approvalLog);
                        return array('id' => 0, 'message' => 'false');
                    }


                } else {
                    return response(array('id' => 0, 'message' => 'Environment Officer Not Found'), 404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function approveAssitanceDirector($eplId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'date' => 'required|date',
                'comment' => 'required|string'
            ]);
            $epl = EPL::find($eplId);
            if ($epl) {
                if ($epl->client->environment_officer_id != null) {
                    $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                        ->where('type_id', $epl->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($abc->officer_type == ApprovalLog::OFF_A_DIRECTOR && $abc->status == ApprovalLog::APP_APPROVE) {
                        return response(array('id' => 0, 'message' => 'Already Rejected'), 422);
                    }
                    $approvalLog = new ApprovalLog();
                    $approvalLog->type = ApprovalLog::Type_EPL;
                    $approvalLog->type_id = $epl->id;
                    $approvalLog->officer_type = ApprovalLog::OFF_A_DIRECTOR;
                    $env = EnvironmentOfficer::findOrFail($epl->client->environment_officer_id);
                    $approvalLog->user_id = $env->assistant_director_id;
                    $approvalLog->comment = request('comment');
                    $approvalLog->status = ApprovalLog::APP_APPROVE;
                    $approvalLog->approve_date = Carbon::now()->toDateTimeString();
                    $msg = $approvalLog->save();
                               
                    if ($msg) {
                        LogActivity::addToLog('approveAssitanceDirector done : ApprovalLogController',$approvalLog);            
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        LogActivity::addToLog('approveAssitanceDirector Fail : ApprovalLogController',$approvalLog);
                        return array('id' => 0, 'message' => 'false');
                    }

                } else {
                    return response(array('id' => 0, 'message' => 'Environment Officer Not Found'), 404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function rejectAssitanceDirector($eplId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'date' => 'required|date',
                'comment' => 'required|string'
            ]);
            $epl = EPL::find($eplId);
            if ($epl) {
                if ($epl->client->environment_officer_id != null) {
                    $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                        ->where('type_id', $epl->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($abc->officer_type == ApprovalLog::OFF_A_DIRECTOR && $abc->status == ApprovalLog::APP_REJECT) {
                        return response(array('id' => 0, 'message' => 'Already Rejected'), 422);
                    }
                    $approvalLog = new ApprovalLog();
                    $approvalLog->type = ApprovalLog::Type_EPL;
                    $approvalLog->type_id = $epl->id;
                    $approvalLog->officer_type = ApprovalLog::OFF_A_DIRECTOR;
                    $env = EnvironmentOfficer::findOrFail($epl->client->environment_officer_id);
                    $approvalLog->user_id = $env->assistant_director_id;
                    $approvalLog->comment = request('comment');
                    $approvalLog->status = ApprovalLog::APP_REJECT;
                    $approvalLog->approve_date = Carbon::now()->toDateTimeString();
                    $msg = $approvalLog->save();
                    if ($msg) {
                        LogActivity::addToLog('rejectAssitanceDirector done : ApprovalLogController',$approvalLog);            
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        LogActivity::addToLog('rejectAssitanceDirector Fail : ApprovalLogController',$approvalLog);
                        return array('id' => 0, 'message' => 'false');
                    }
                } else {
                    return response(array('id' => 0, 'message' => 'Environment Officer Not Found'), 404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function approveDirector($eplId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'date' => 'required|date',
                'comment' => 'required|string'
            ]);
            $epl = EPL::find($eplId);
            if ($epl) {
                if ($epl->client->environment_officer_id != null) {
                    $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                        ->where('type_id', $epl->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($abc->officer_type == ApprovalLog::OFF_DIRECTOR && $abc->status == ApprovalLog::APP_APPROVE) {
                        return response(array('id' => 0, 'message' => 'Already Approved'), 422);
                    }
                    $approvalLog = new ApprovalLog();
                    $approvalLog->type = ApprovalLog::Type_EPL;
                    $approvalLog->type_id = $epl->id;
                    $approvalLog->officer_type = ApprovalLog::OFF_DIRECTOR;
                    $approvalLog->comment = request('comment');
                    $approvalLog->status = ApprovalLog::APP_APPROVE;
                    $approvalLog->approve_date = Carbon::now()->toDateTimeString();
                    $msg = $approvalLog->save();
                    if ($msg) {
                        LogActivity::addToLog('approveDirector done : ApprovalLogController',$approvalLog);            
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        LogActivity::addToLog('approveDirector Fail : ApprovalLogController',$approvalLog);
                        return array('id' => 0, 'message' => 'false');
                    }


                } else {
                    return response(array('id' => 0, 'message' => 'Environment Officer Not Found'), 404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function rejectDirector($eplId)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'date' => 'required|date',
                'comment' => 'required|string'
            ]);
            $epl = EPL::find($eplId);
            if ($epl) {
                if ($epl->client->environment_officer_id != null) {
                    $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                        ->where('type_id', $epl->id)
                        ->orderBy('id', 'desc')
                        ->first();
                    if ($abc->officer_type == ApprovalLog::OFF_DIRECTOR && $abc->status == ApprovalLog::APP_REJECT) {
                        return response(array('id' => 0, 'message' => 'Already Rejected'), 422);
                    }
                    $approvalLog = new ApprovalLog();
                    $approvalLog->type = ApprovalLog::Type_EPL;
                    $approvalLog->type_id = $epl->id;
                    $approvalLog->officer_type = ApprovalLog::OFF_DIRECTOR;
                    $approvalLog->comment = request('comment');
                    $approvalLog->status = ApprovalLog::APP_REJECT;
                    $approvalLog->approve_date = Carbon::now()->toDateTimeString();
                    $msg = $approvalLog->save();
                    if ($msg) {
                        LogActivity::addToLog('rejectDirector done : ApprovalLogController',$approvalLog);            
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        LogActivity::addToLog('rejectDirector Fail : ApprovalLogController',$approvalLog);
                        return array('id' => 0, 'message' => 'false');
                    }
                } else {
                    return response(array('id' => 0, 'message' => 'Environment Officer Not Found'), 404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function getLog($id)
    {
        $epl = EPL::find($id);
        if ($epl) {
            return ApprovalLog::where('type', ApprovalLog::Type_EPL)->where('type_id', $epl->id)->orderBy('approve_date', 'DESC')->get();
        } else {
            abort(404);
        }
    }

    public function current($id)
    {
        $epl = EPL::find($id);
        if ($epl) {
            $abc = ApprovalLog::where('type', ApprovalLog::Type_EPL)
                ->where('type_id', $epl->id)
                ->orderBy('id', 'desc')
                ->first();
            if ($abc) {
                return $abc;
            } else {
                return array("officer_type" => "new", "status" => 1);
            }
        } else {
            abort(404);
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
     * @param  \App\ApprovalLog  $approvalLog
     * @return \Illuminate\Http\Response
     */
    public function show(ApprovalLog $approvalLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApprovalLog  $approvalLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ApprovalLog $approvalLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApprovalLog  $approvalLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApprovalLog $approvalLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApprovalLog  $approvalLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApprovalLog $approvalLog)
    {
        //
    }
}
