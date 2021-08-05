<?php

namespace App\Http\Controllers;

use App\InspectionRemarks;
use App\InspectionSession;
use App\InspectionSessionAttachment;
use App\EPL;
use App\Client;
use App\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class InspectionRemarksController extends Controller
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
            $InspectionSession = InspectionSession::find($id);
            if ($InspectionSession !== null) {
                $file = Client::find($InspectionSession->client_id);
                $inspection_attachments = InspectionSessionAttachment::where('inspection_session_id', '=', $id)->get();
                return view('inspection_remarks', ['pageAuth' => $pageAuth, 'id' => $id, "inspec_date" => date("Y-m-d", strtotime($InspectionSession->schedule_date)), "file_no" => $file->file_no, "file_id" => $file->id, "inspect_file_attach" => $inspection_attachments]);
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
    public function create($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        request()->validate([
            'remark' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            $inspection_remark = new InspectionRemarks();
            $inspection_remark->remark = \request('remark');
            $inspection_remark->inspection_session_id = $id;
            $inspection_remark->user_id = $user->id;
            $msg = $inspection_remark->save();

            if ($msg) {
                LogActivity::addToLog(' Inspection Remark added', $inspection_remark);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
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
    public function store()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InspectionRemarks::with('user')->where('inspection_session_id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionRemarks $inspectionRemarks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $inspection_remark = InspectionRemarks::findOrFail($id);;
            $msg = $inspection_remark->delete();

            if ($msg) {
                LogActivity::addToLog(' Inspection Remark deleted', $inspection_remark);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }
}
