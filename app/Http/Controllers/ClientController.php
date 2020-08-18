<?php

namespace App\Http\Controllers;

use App\Level;
use App\Client;
use Carbon\Carbon;
use App\BusinessScale;
use App\Pradesheeyasaba;
use App\Rules\contactNo;
use App\IndustryCategory;
use App\Rules\nationalID;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller {

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
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('client_space', ['pageAuth' => $pageAuth]);
    }

    public function indexOldFileList() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_file_list', ['pageAuth' => $pageAuth]);
    }

    public function indexOldDataReg($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_data_registation', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    public function allClientsindex() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.industryFile'));
        if ($pageAuth['is_read']) {
            return view('industry_files', ['pageAuth' => $pageAuth]);
        } else {
            abort(401);
        }
    }

    public function index1($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            return view('industry_profile', ['pageAuth' => $pageAuth, 'id' => $id]);
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable',
            'contact_no' => ['nullable', new contactNo],
            'email' => 'nullable|sometimes',
            'nic' => ['sometimes', 'nullable', 'unique:clients', new nationalID],
            'industry_name' => 'required|string',
            'industry_category_id' => 'required|integer',
            'business_scale_id' => 'required|integer',
            'industry_contact_no' => ['nullable', new contactNo],
            'industry_address' => 'required|string',
            'industry_email' => 'nullable|email',
            'industry_coordinate_x' => ['numeric', 'required', 'between:-180,180'],
            'industry_coordinate_y' => ['numeric', 'required', 'between:-90,90'],
            'pradesheeyasaba_id' => 'required|integer',
            'industry_is_industry' => 'required|integer',
            'industry_investment' => 'required|numeric',
            'industry_start_date' => 'required|date',
            'industry_registration_no' => 'nullable|string',
            'is_old' => 'required|integer',
                // 'password' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            $client = new Client();
            $client->first_name = \request('first_name');
            $client->last_name = \request('last_name');
            $client->address = \request('address');
            $client->contact_no = \request('contact_no');
            $client->email = \request('email');
            $client->nic = \request('nic');
            $client->password = Hash::make(request('nic'));
            $client->api_token = Str::random(80);

            $client->industry_name = \request('industry_name');
            $client->industry_category_id = \request('industry_category_id');
            $client->business_scale_id = \request('business_scale_id');
            $client->industry_contact_no = \request('industry_contact_no');
            $client->industry_address = \request('industry_address');
            $client->industry_email = \request('industry_email');
            $client->industry_coordinate_x = \request('industry_coordinate_x');
            $client->industry_coordinate_y = \request('industry_coordinate_y');
            $client->pradesheeyasaba_id = \request('pradesheeyasaba_id');
            $client->industry_is_industry = \request('industry_is_industry');
            $client->industry_investment = \request('industry_investment');
            $client->industry_start_date = \request('industry_start_date');
            $client->industry_registration_no = \request('industry_registration_no');
            $client->is_old = \request('is_old');


            $msg = $client->save();
            $client->file_no = $this->generateCode($client);
            // dd($client->file_no);
            $msg = $msg && $client->save();
            if ($msg) {
                return array('id' => 1, 'message' => 'true', 'id' => $client->id);
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    private function generateCode($client) {
        $la = Pradesheeyasaba::find($client->pradesheeyasaba_id);
        // print_r($la);
        $lsCOde = $la->code;

        $industry = IndustryCategory::find($client->industry_category_id);
        $industryCode = $industry->code;
        $scale = BusinessScale::find($client->business_scale_id);
        $scaleCode = $scale->code;

        $e = Client::orderBy('id', 'desc')->first();
        if ($e === null) {
            $serial = 1;
        } else {
            $serial = $e->id;
        }
        $serial = sprintf('%02d', $serial);
        return "PEA/" . $lsCOde . "/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id) {
        // ,register_no,' . $vehicle->id
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'contact_no' => ['required', new contactNo],
            'email' => 'nullable|sometimes',
        ]);
        if ($pageAuth['is_update']) {
            $client = Client::findOrFail($id);
            $client->first_name = \request('first_name');
            $client->last_name = \request('last_name');
            $client->address = \request('address');
            $client->contact_no = \request('contact_no');
            $client->email = \request('email');
            $msg = $client->save();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function getClientById($id) {
        return Client::findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            return Client::get();
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_delete']) {
            $client = Client::findOrFail($id);
            $msg = $client->delete();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function findClient_by_nic($nic) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        return Client::with('epls')->with('oldFiles')->where('nic', '=', $nic)
                        ->get();
    }

    public function findClient_by_id($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        return Client::with('epls')->with('environmentOfficer.user')->with('oldFiles')->with('industryCategory')->with('businessScale')->with('pradesheeyasaba')->find($id);
    }

    public function getAllFiles($id) {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::DIRECTOR) {
            $client = Client::where('environment_officer_id', $id)->get();
            if ($client->environmentOfficer->assistantDirector->id == $user->id) {
                $data = $client;
            } else {
                abort(401);
            }
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $data = Client::where('environment_officer_id', $user->id)->get();
        } else {
            abort(401);
        }
        //    Client::where()

        return $data;
    }

    public function workingFiles($id) {

        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->where('is_working', 1)->get();
        } else if ($user->roll->level->name == Level::DIRECTOR) {
            $client = Client::where('environment_officer_id', $id)->where('is_working', 1)->get();
            if ($client->environmentOfficer->assistantDirector->id == $user->id) {
                $data = $client;
            } else {
                abort(401);
            }
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $data = Client::where('environment_officer_id', $user->id)->where('is_working', 1)->get();
        } else {
            abort(401);
        }
        //    Client::where()

        return $data;
    }

    public function newlyAssigned($id) {
        $dateTo = Carbon::now();
        $dateFrom = Carbon::now()->subDays(7);
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)
                    ->whereBetween('assign_date', [$dateFrom, $dateTo])
                    ->get();
        } else if ($user->roll->level->name == Level::DIRECTOR) {
            $client = Client::where('environment_officer_id', $id)
                    ->whereBetween('assign_date', [$dateFrom, $dateTo])
                    ->get();
            if ($client->environmentOfficer->assistantDirector->id == $user->id) {
                $data = $client;
            } else {
                abort(401);
            }
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $data = Client::where('environment_officer_id', $user->id)
                    ->whereBetween('assign_date', [$dateFrom, $dateTo])
                    ->get();
        } else {
            abort(401);
        }
        //    Client::where()

        return $data;
    }

    public function getOldFiles() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        return Client::where('is_old', 0)->with('epls')->with('oldFiles')->get();
    }

    public function markOldFinish($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::find($id);
        $client->is_old = 2; // inspected state
        $client->is_working = 0; // set working status of the client to not working
        if ($client->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getOldFilesDetails($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::where('is_old', 0)->where('id', $id)->first();
        if ($client) {
            $epls = $client->epls;
//            dd($client);
            if (count($epls) > 0) {
                return $client->epls[0];
            } else {
                return $epls;
            }
        } else {
            abort(404);
        }
    }

}
