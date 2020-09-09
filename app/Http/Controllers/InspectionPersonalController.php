<?php

namespace App\Http\Controllers;

use App\InspectionPersonal;
use App\InspectionSession;
use App\ApplicationType;
use App\EPL;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionPersonalController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            $InspectionSession = InspectionSession::find($id);
            if ($InspectionSession) {
                $file = Client::find($InspectionSession->client_id);
                return view('inspection_personal', ['pageAuth' => $pageAuth, 'id' => $id, 'inspection_session_date' => date('Y-m-d', strtotime($InspectionSession->schedule_date)), "file_no" => $file->file_no, "file_id" => $file->id]);
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
    public function create($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        request()->validate([
            'name' => 'required|string',
        ]);
        if ($pageAuth['is_create']) {
            $inspection_personal = new InspectionPersonal();
            $inspection_personal->name = \request('name');
            $inspection_personal->inspection_session_id = $id;
            $msg = $inspection_personal->save();

            if ($msg) {
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
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionPersonal  $inspectionPersonal
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return InspectionPersonal::with('user')->where('inspection_session_id', $id)->get();
    }

    public function find($sessionId) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return InspectionPersonal::findOrFail($sessionId);
    }

    public function showInspectionsPersonal($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return InspectionPersonal::where('inspection_session_id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionPersonal  $inspectionPersonal
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionPersonal $inspectionPersonal) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionPersonal  $inspectionPersonal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionPersonal $inspectionPersonal) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionPersonal  $inspectionPersonal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $inspection_personal = InspectionPersonal::findOrFail($id);
            ;
            $msg = $inspection_personal->delete();

            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

}
