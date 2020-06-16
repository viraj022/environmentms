<?php

namespace App\Http\Controllers;

use App\EPL;
use App\User;
use App\Level;
use Carbon\Carbon;
use App\Attachemnt;
use App\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttachemntsController extends Controller {

    public function __construct() {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            return view('attachements', ['pageAuth' => $pageAuth]);
        }
    }

    public function isNameUnique($name) {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));

        if ($pageAuth['is_create']) {
            $raw = Attachemnt::where('name', '=', $name)->first();
            if ($raw === null) {
                return array('id' => 1, 'message' => 'unique');
            } else {
                return array('id' => 1, 'message' => 'notunique');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        request()->validate([
            'name' => 'required|unique:attachemnts,name',
        ]);
        if ($pageAuth['is_create']) {
            $attachment = new Attachemnt();
            $attachment->name = \request('name');
            $msg = $attachment->save();

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
    public function store($id) {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        request()->validate([
            'name' => 'required|unique:attachemnts,name',
        ]);
        if ($pageAuth['is_update']) {
            $attachment = Attachemnt::findOrFail($id);
            ;
            $attachment->name = \request('name');
            $msg = $attachment->save();

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
     * Display the specified resource.
     *
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            return Attachemnt::get();
        } else {
            abort(401);
        }
    }

    public function find($id) {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            return Attachemnt::findOrFail($id);
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachemnt $attachemnts) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_delete']) {
            $attachment = Attachemnt::findOrFail($id);
            ;
            //$attachment->name= \request('name');
            $msg = $attachment->delete();

            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function getAttachment_by_application_name($application_name) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            // return Attachemnt::get();
            return Attachemnt::join('application_type_attachemnt', 'application_type_attachemnt.attachemnt_id', '=', 'attachemnts.id')
                            ->join('application_types', 'application_type_attachemnt.application_type_id', '=', 'application_types.id')
                            ->select('attachemnts.*')
                            ->where('application_types.name', '=', $application_name)
                            ->get();
        } else {
            abort(401);
        }
    }
<<<<<<< HEAD

    public function attach($attachment, $epl) {
        return array('id' => 1, 'message' => 'true');
    }

    public function revoke($officer, $epl) {
=======
    public function attach($attachment, $epl)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_create']) {
            $data = \request('file');
            $array = explode(';', $data);
            $array2 = explode(',', $array[1]);
            $array3 = explode('/', $array[0]);
            $type = $array3[1];
            $data = base64_decode($array2[1]);
            file_put_contents($this->makeApplicationPath($epl, $attachment) . "1" . $type, $data);
            $path =  $this->makeApplicationPath($epl, $attachment) . "1." . $type;
            $e = EPL::findOrFail($epl);
            return  \DB::transaction(function ()  use ($attachment, $e, $path, $type) {
                $e->attachemnts()->detach($attachment);
                $e->attachemnts()->attach(
                    $attachment,
                    [
                        'path' => $path,
                        'type' => $type,
                        'created_at' => Carbon::now()->toDateTimeString()
                    ]
                );
                return array('id' => 1, 'message' => 'true');
            });
        } else {
            abort(401);
        }
    }

    public function revoke($attachment, $epl)
    {
        $e = EPL::findOrFail($epl);
        $e->attachemnts()->detach($attachment);
>>>>>>> remotes/origin/feature/add-attach
        return array('id' => 1, 'message' => 'true');
    }

    public function getEplAttachments($epl) {
        return DB::select(DB::raw("SELECT b.path, b.type, b.attachment_epl_id, a.att_id FROM (SELECT
	application_types.`name`, 
	attachemnts.`name` AS attachment_name,
	attachemnts.id AS att_id
FROM attachemnts
	INNER JOIN application_type_attachemnt ON  attachemnts.id = application_type_attachemnt.attachemnt_id
	INNER JOIN application_types ON application_type_attachemnt.application_type_id = application_types.id
WHERE application_types.`name` = 'Environment Protection Licence') AS a
	LEFT JOIN
	(SELECT
	attachemnt_e_p_l.path, 
	attachemnt_e_p_l.type, 
	attachemnt_e_p_l.attachemnt_id,
	attachemnt_e_p_l.id AS attachment_epl_id
FROM attachemnt_e_p_l
WHERE attachemnt_e_p_l.e_p_l_id = 8) AS b
	ON a.att_id=b.attachemnt_id"));
//        $attachemntsAll = Attachemnt::join('application_type_attachemnt', 'application_type_attachemnt.attachemnt_id', '=', 'attachemnts.id')
//                ->join('application_types', 'application_type_attachemnt.application_type_id', '=', 'application_types.id')
//                ->select('attachemnts.*')
//                ->where('application_types.name', '=', ApplicationTypeController::EPL)
//                ->get();
//
//        $epl = EPL::find($epl);
//
//        return $attachemntsAssigned = $epl->attachemnts;
    }

<<<<<<< HEAD
=======
    private function makeApplicationPath($id, $attachemntId)
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
        if (!is_dir("uploads/EPL/" . $id . "/attachments")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/attachments");
        }
        if (!is_dir("uploads/EPL/" . $id . "/attachments/" . $attachemntId)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/attachments/" . $attachemntId);
        }
        return "uploads/EPL/" . $id . "/attachments/" . $attachemntId . "/";
    }
>>>>>>> remotes/origin/feature/add-attach
}
