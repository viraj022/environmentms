<?php

namespace App\Http\Controllers;

use App\Remark;
use App\EPL;
use App\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarkController extends Controller {

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
                return view('remarks', ['pageAuth' => $pageAuth, 'id' => $id]);
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
            'remark' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            $remark = new Remark();
            $remark->remark = \request('remark');
            $remark->application_type_id = ApplicationType::getByName(ApplicationTypeController::EPL)->id;
            $remark->profile_id = $id;
            $remark->user_id = $user->id;
            $msg = $remark->save();

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
     * @param  \App\Remarks  $remarks
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return Remark::where('profile_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Remarks  $remarks
     * @return \Illuminate\Http\Response
     */
    public function edit(Remarks $remarks) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Remarks  $remarks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remarks $remarks) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remarks  $remarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remarks $remarks) {
        //
    }

}
