<?php

namespace App\Http\Controllers;

use App\EPL;
use App\EPLRenew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class EPLRenewController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
       
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $epl = EPL::findOrFail($id);
//         dd($epl->client_id);
        return view('renewal_page', ['pageAuth' => $pageAuth,'id' => $epl->client_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            return \DB::transaction(function () use ($id) {
                        request()->validate([
                            'e_p_l_id' => 'required|integer',
                            'submit_date' => ['required', 'date'],
                            'remark' => ['sometimes', 'nullable'],
                            'is_old' => 'required|integer',
                        ]);
                        $epl = EPL::find($id);
                        if ($epl) {
                            // dd($epl->getRenewCount());
                            $ePLRenew = new EPLRenew();
                            $ePLRenew->e_p_l_id = $epl->id;
                            $ePLRenew->submit_date = request('submit_date');
                            $ePLRenew->remark = request('remark');
                            $ePLRenew->is_old = request('is_old');
                            $ePLRenew->count = $epl->getRenewCount() + 1;
                            $epl->application_path = "";
                            $data = \request('file');
                            $array = explode(';', $data);
                            $array2 = explode(',', $array[1]);
                            $array3 = explode('/', $array[0]);
                            $type = $array3[1];
                            $data = base64_decode($array2[1]);
                            file_put_contents($this->makeApplicationPath($epl->id) . $epl->getNextRnumber() . "." . $type, $data);
                            $ePLRenew->renew_application_path = $this->makeApplicationPath($epl->id) . $epl->getNextRnumber() . "." . $type;
                            $msg = $ePLRenew->save();
                            if ($msg) {
                                LogActivity::fileLog($ePLRenew->id, 'EPLrenew', "EPLRenew Created", 1);
                                LogActivity::addToLog('EPLRenew Created',$ePLRenew);
                                return array('id' => 1, 'message' => 'true');
                            } else {
                                LogActivity::addToLog('Fail to Create EPLRenew',$ePLRenew);
                                return array('id' => 0, 'message' => 'false');
                            }
                        } else {
                            abort(404);
                        }
                    });
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
     * @param  \App\EPLRenew  $ePLRenew
     * @return \Illuminate\Http\Response
     */
    public function show(EPLRenew $ePLRenew) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EPLRenew  $ePLRenew
     * @return \Illuminate\Http\Response
     */
    public function edit(EPLRenew $ePLRenew) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EPLRenew  $ePLRenew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EPLRenew $ePLRenew) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EPLRenew  $ePLRenew
     * @return \Illuminate\Http\Response
     */
    public function destroy(EPLRenew $ePLRenew) {
        //
    }

    private function makeApplicationPath($id) {
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
        if (!is_dir("uploads/EPL/" . $id . "/application")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/application");
        }
        return "uploads/EPL/" . $id . "/application/";
    }

}
