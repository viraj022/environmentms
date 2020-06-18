<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\ApplicationType;
use App\InspectionSession;
use Illuminate\Http\Request;
use App\InspectionSessionAttachment;
use Illuminate\Support\Facades\Auth;

class InspectionSessionAttachmentController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEPlInspection($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $inspection =  InspectionSession::where('id', $id)->where('application_type_id', ApplicationType::getByName(ApplicationTypeController::EPL))->first();
            if ($inspection) {
                $data = \request('file');
                $array = explode(';', $data);
                $array2 = explode(',', $array[1]);
                $array3 = explode('/', $array[0]);
                $type = $array3[1];
                if (!($type == 'jpeg' || $type == 'pdf')) {
                    return array('id' => 0, 'message' => 'Only you can add image(jpeg) or PDF');
                }
                $data = base64_decode($array2[1]);
                $name = Carbon::now()->timestamp;
                file_put_contents($this->makeEPLApplicationPath($inspection->profile_id, $id) . "" . $name . "." . $type, $data);
                $path = $this->makeEPLApplicationPath($inspection->profile_id, $id) . "" . $name . "." . $type;
                $inspectionSessionAttachment = new InspectionSessionAttachment();
                $inspectionSessionAttachment->inspection_session_id  = $id;
                $inspectionSessionAttachment->path  = $path;
                $inspectionSessionAttachment->type  = $type;
                $msg =   $inspectionSessionAttachment->save();
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
            return  InspectionSessionAttachment::where('inspection_session_id', $id)->get();
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
            $inspectionSessionAttachment =  InspectionSessionAttachment::findOrFail($id);
            $msg =   $inspectionSessionAttachment->delete();
            if ($msg) {
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
