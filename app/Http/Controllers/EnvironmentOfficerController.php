<?php

namespace App\Http\Controllers;

use App\EPL;
use App\User;
use App\AssistantDirector;
use App\Client;
use App\EnvironmentOfficer;
use App\FileHandlerLog;
use Illuminate\Cache\Console\ClearCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnvironmentOfficerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        return view('environment_officer', ['pageAuth' => $pageAuth]);
    }

    public function index2()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        return view('epl_assign', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        request()->validate([
            'user_id' => 'required',
            'assistantDirector_id' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            if ($this->checkAssistantDirector(\request('user_id'))) {
                if ($this->checkEnvironmentOfficer(\request('user_id'))) {
                    $environmentOfficer = new EnvironmentOfficer();
                    $environmentOfficer->user_id = \request('user_id');
                    $environmentOfficer->assistant_director_id = \request('assistantDirector_id');
                    $environmentOfficer->active_status = '1';
                    $msg = $environmentOfficer->save();
                    if ($msg) {
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                } else {
                    return array('message' => 'Custom Validation unprocessable entry', 'errors' => array('user_id' => 'user is already already assigned as an active environment officer'));
                }
            } else {
                return array('message' => 'Custom Validation unprocessable entry', 'errors' => array('user_id' => 'can not assign active assistant directer as an environment officer'));
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
     * @param  \App\EnvironmentOfficer  $environmentOfficer
     * @return \Illuminate\Http\Response
     */
    public function show(EnvironmentOfficer $environmentOfficer)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($pageAuth['is_read']) {
            $assistantDirectors = AssistantDirector::where('active_status', '1')->select('user_id as id')->get();
            $environmentOfficers = EnvironmentOfficer::where('active_status', '1')->select('user_id as id')->get();
            return User::wherenotin('id', $assistantDirectors)->wherenotin('id', $environmentOfficers)->get();
        } else {
            abort(401);
        }
    }

    public function getAEnvironmentOfficer($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($pageAuth['is_read']) {
            return EnvironmentOfficer::where('environment_officers.id', '=', $id)
                ->where('environment_officers.active_status', '=', 1)
                ->join('assistant_directors', 'environment_officers.assistant_director_id', 'assistant_directors.id')
                ->join('zones', 'assistant_directors.zone_id', 'zones.id')
                ->join('users', 'environment_officers.user_id', '=', 'users.id')
                ->join('users as assistant_director_users', 'environment_officers.assistant_director_id', '=', 'assistant_director_users.id')
                ->select(
                    'environment_officers.id',
                    'users.first_name as first_name',
                    'users.last_name as last_name',
                    'users.user_name as user_name',
                    'users.id as user_id',
                    'environment_officers.active_status',
                    'zones.id as zone_id',
                    'zones.name as zone_name',
                    'assistant_director_users.first_name as assistant_director_first_name',
                    'assistant_director_users.last_name as assistant_director_last_name',
                    'assistant_director_users.user_name as assistant_director_user_name'
                )
                ->first();
        } else {
            abort(401);
        }
    }

    public function getAEnvironmentOfficerByAssitantDirector($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($pageAuth['is_read']) {
            return EnvironmentOfficer::where('environment_officers.assistant_director_id', '=', $id)
                ->where('environment_officers.active_status', '=', 1)
                ->join('assistant_directors', 'environment_officers.assistant_director_id', 'assistant_directors.id')
                ->join('zones', 'assistant_directors.zone_id', 'zones.id')
                ->join('users', 'environment_officers.user_id', '=', 'users.id')
                ->join('users as assistant_director_users', 'environment_officers.assistant_director_id', '=', 'assistant_director_users.id')
                ->select(
                    'environment_officers.id',
                    'users.first_name as first_name',
                    'users.last_name as last_name',
                    'users.user_name as user_name',
                    'users.id as user_id',
                    'environment_officers.active_status',
                    'zones.id as zone_id',
                    'zones.name as zone_name',
                    'assistant_director_users.first_name as assistant_director_first_name',
                    'assistant_director_users.last_name as assistant_director_last_name',
                    'assistant_director_users.user_name as assistant_director_user_name'
                )
                ->get();
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EnvironmentOfficer  $environmentOfficer
     * @return \Illuminate\Http\Response
     */
    public function edit(EnvironmentOfficer $environmentOfficer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EnvironmentOfficer  $environmentOfficer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnvironmentOfficer $environmentOfficer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EnvironmentOfficer  $environmentOfficer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $environmentOfficer = EnvironmentOfficer::find($id);
        if ($environmentOfficer !== null) {
            $environmentOfficer->active_status = 0;
            $msg = $environmentOfficer->save();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function checkAssistantDirector($id)
    {
        $assistantDirector = AssistantDirector::where('user_id', '=', $id)
            ->where('active_status', '=', 1)->first();
        if ($assistantDirector === null) {
            return true;
        } else {
            return false;
        }
    }

    public function checkEnvironmentOfficer($id)
    {
        $environmentOfficer = EnvironmentOfficer::where('user_id', '=', $id)
            ->where('active_status', '=', 1)->first();
        if ($environmentOfficer === null) {
            return true;
        } else {
            return false;
        }
    }

    public function assignEnvOfficer($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'environment_officer_id' => 'required|integer',
            ]);
            $client = Client::find($id);
            $environmentOfficer = EnvironmentOfficer::find(\request('environment_officer_id'));
            if ($client && $environmentOfficer) {
                $client->environment_officer_id = $environmentOfficer->id;
                $msg = $client->save();
                $officeLog = new FileHandlerLog();
                $officeLog->type = ApplicationTypeController::EPL;
                $officeLog->environment_officer_id = $environmentOfficer->id;
                $officeLog->assistant_director_id = $environmentOfficer->assistant_director_id;
                $msg = $msg && $officeLog->save();
                if ($msg) {
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function remove($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $epl = EPL::find($id);
            if ($epl) {
                $epl->environment_officer_id = null;
                $msg = $epl->save();
                if ($msg) {
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function getEplByAssistantDirector($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            $assistantDirector = AssistantDirector::find($id);
            if ($assistantDirector) {
                return Client::join('pradesheeyasabas', 'clients.pradesheeyasaba_id', '=', 'pradesheeyasabas.id')
                    ->whereNull('environment_officer_id')
                    ->where('pradesheeyasabas.zone_id', $assistantDirector->zone_id)
                    ->select('clients.*')
                    ->get();
            } else {
                abort(404);
            }
        } else {
            return abort(401);
        }
    }

    public function getEplByEnvOfficer($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            return Client::where('environment_officer_id', $id)
                ->get();
        } else {
            abort(401);
        }
    }

    public function All()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($pageAuth['is_read']) {
            return EnvironmentOfficer::join('users', 'environment_officers.user_id', 'users.id')->select('users.*')->get();
        } else {
            abort(401);
        }
    }
}
