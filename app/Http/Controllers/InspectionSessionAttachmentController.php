<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\ApplicationType;
use App\EPL;
use App\Client;
use App\InspectionSession;
use Illuminate\Http\Request;
use App\InspectionSessionAttachment;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class InspectionSessionAttachmentController extends Controller
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
            if ($InspectionSession) {
                $file = Client::find($InspectionSession->client_id);
                return view('inspection_attachment', ['pageAuth' => $pageAuth, 'id' => $id, "inspec_date" => date("Y-m-d", strtotime($InspectionSession->schedule_date)), "file_no" => $file->file_no, "file_id" => $file->id]);
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
    public function createEPlInspection($id, Request $request)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $inspection = InspectionSession::find($id);
            if ($inspection) {
                $e = Client::findOrFail($inspection->client_id);
                $type = $request->file->extension();
                $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                $fileUrl = "/uploads/" . FieUploadController::getInspectionFilePath($inspection);
                $storePath = 'public' . $fileUrl;
                $path = 'storage' . $fileUrl . "/" . $file_name;
                $request->file('file')->storeAs($storePath, $file_name);
                $inspectionSessionAttachment = new InspectionSessionAttachment();
                $inspectionSessionAttachment->inspection_session_id = $id;
                $inspectionSessionAttachment->path = $path;
                $inspectionSessionAttachment->type = $type;
                $msg = $inspectionSessionAttachment->save();
                dd($path);


                if ($msg) {
                    LogActivity::addToLog('Add Inspection attachment', $inspectionSessionAttachment);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function showEpl($id)
    {
        $user = Auth::user($id);
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            return InspectionSessionAttachment::where('inspection_session_id', $id)->get();
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionSessionAttachment $inspectionSessionAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionSessionAttachment $inspectionSessionAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $inspectionSessionAttachment = InspectionSessionAttachment::findOrFail($id);
            $msg = $inspectionSessionAttachment->delete();

            if ($msg) {
                LogActivity::addToLog('Delete inspection attachment', $inspectionSessionAttachment);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    private function makeEPLApplicationPath($id, $attachemntId)
    {
        if (!is_dir("uploads")) {
            //Create our directory if it does not exist
            mkdir("uploads");
        }
        if (!is_dir("uploads/EPL")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL");
        }
        if (!is_dir("uploads/EPL/" . $id)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id);
        }
        if (!is_dir("uploads/EPL/" . $id . "/inspections")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/inspections");
        }
        if (!is_dir("uploads/EPL/" . $id . "/inspections/" . $attachemntId)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/inspections/" . $attachemntId);
        }
        return "uploads/EPL/" . $id . "/inspections/" . $attachemntId . "/";
    }
}
