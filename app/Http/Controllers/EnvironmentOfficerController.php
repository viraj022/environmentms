<?php

namespace App\Http\Controllers;

use App\EPL;
use App\User;
use App\Level;
use App\Client;
use App\Minute;
use Carbon\Carbon;
use App\FileHandlerLog;
use App\AssistantDirector;
use App\EnvironmentOfficer;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MinutesRepository;
use Illuminate\Cache\Console\ClearCommand;

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
        $pageAuth = $user->authentication(config('auth.privileges.fileAssign'));
//        dd($pageAuth);
        return view('epl_assign', ['pageAuth' => $pageAuth]);
    }

    public function index3()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        return view('schedule', ['pageAuth' => $pageAuth]);
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
                    LogActivity::addToLog('Create a new environment Officer', $environmentOfficer);
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
            return User::whereHas('roll.level', function ($queary) {
                $queary->where('name', Level::ENV_OFFICER);
            })->wherenotin('id', $assistantDirectors)->wherenotin('id', $environmentOfficers)->get();
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
        // dd($id);
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.fileAssign'));
        if ($pageAuth['is_read']) {
            return EnvironmentOfficer::where('environment_officers.assistant_director_id', '=', $id)
                ->where('environment_officers.active_status', '=', 1)
                ->join('assistant_directors', 'environment_officers.assistant_director_id', 'assistant_directors.id')
                ->join('zones', 'assistant_directors.zone_id', 'zones.id')
                ->join('users', 'environment_officers.user_id', '=', 'users.id')
                ->join('users as assistant_director_users', 'assistant_directors.user_id', '=', 'assistant_director_users.id')
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
            LogActivity::addToLog('Delete environment officer', $environmentOfficer);
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
        $pageAuth = $user->authentication(config('auth.privileges.fileAssign'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'environment_officer_id' => 'required|integer',
            ]);
            $client = Client::find($id);
            $environmentOfficer = EnvironmentOfficer::find(\request('environment_officer_id'));
            if ($client && $environmentOfficer) {
                $client->environment_officer_id = $environmentOfficer->id;
                $client->assign_date = Carbon::now();
                $msg = $client->save();

                $officeLog = new FileHandlerLog();
                $officeLog->type = ApplicationTypeController::EPL;
                $officeLog->environment_officer_id = $environmentOfficer->id;
                $officeLog->assistant_director_id = $environmentOfficer->assistant_director_id;
                $msg = $msg && $officeLog->save();
                if ($msg) {
                    LogActivity::fileLog($client->id, 'File', "Assign an EO", 1);
                    LogActivity::addToLog('Assign an EO', $client);
                    return array('id' => 1, 'message' => 'true');
                } else {
                    LogActivity::addToLog('Fail to assign EPL to Environment Officer  ', $environmentOfficer);
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
            $epl = Client::find($id);
            if ($epl) {
                $epl->environment_officer_id = null;
                $msg = $epl->save();
                if ($msg) {
                    LogActivity::fileLog($epl->id, 'FileAssignEPL', "Environment Officer Removed from EPL", 1);
                    LogActivity::addToLog('Environment Officer Removed from EPL', $epl);
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
    }

    public function getEplByEnvOfficer($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return Client::where('environment_officer_id', $id)
            ->get();
    }

    public function All()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($pageAuth['is_read']) {
            return EnvironmentOfficer::join('users', 'environment_officers.user_id', 'users.id')->select('users.*','environment_officers.id AS env_id')->orderBy('users.first_name', 'ASC')->get();
        } else {
            abort(401);
        }
    }

    public function getEnvironmentOfficersByLevel($id)
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = EnvironmentOfficer::with('user')->where('assistant_director_id', $id)->where('active_status', 1)->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $assistantDirector = AssistantDirector::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($assistantDirector) {
                $data = EnvironmentOfficer::with('user')->where('assistant_director_id', $assistantDirector->id)->where('active_status', 1)->get();
            } else {
                abort(404);
            }
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $data = EnvironmentOfficer::with('user')->where('user_id', $user->id)->where('active_status', 1)->get();
        }
        return $data;
    }

    public function approveFile(Request $request, MinutesRepository $minutesRepository, $officerId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $officerId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $officer = EnvironmentOfficer::with('user')->findOrFail($officerId);

            $msg = setFileStatus($file_id, 'file_status', 1);
            fileLog($file->id, 'Approval', 'EO (' . $officer->user->last_name . ') Approve the file', 0);
            LogActivity::addToLog('EO approve', $file);
            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ENV_APPROVE_FILE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function rejectFile(Request $request, MinutesRepository $minutesRepository, $officerId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $officerId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $officer = EnvironmentOfficer::with('user')->findOrFail($officerId);

            $msg = setFileStatus($file_id, 'file_status', -1);
            fileLog($file->id, 'Rejection', 'EO (' . $officer->user->last_name . ') rejected the file', 0);
            LogActivity::addToLog('EO reject', $file);
            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ENV_REJECT_FILE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function approveCertificate(Request $request, MinutesRepository $minutesRepository, $officerId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $officerId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $officer = EnvironmentOfficer::with('user')->findOrFail($officerId);
            $msg = setFileStatus($file_id, 'file_status', 3);
            $msg = $msg && setFileStatus($file_id, 'cer_status', 3);

            fileLog($file->id, 'Approval', 'EO (' . $officer->user->last_name . ') Approve the certificate', 0);
            LogActivity::addToLog('EO approve certificate', $file);
            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ENV_APPROVE_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function rejectCertificate(Request $request, MinutesRepository $minutesRepository, $officerId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $officerId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $officer = EnvironmentOfficer::with('user')->findOrFail($officerId);
            $msg = setFileStatus($file_id, 'file_status', 2);
            $msg = $msg && setFileStatus($file_id, 'cer_status', 1);
            fileLog($file->id, 'Rejection', 'EO (' . $officer->user->last_name . ') Rejected the certificate', 0);
            LogActivity::addToLog('EO reject certificate', $file);
            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ENV_REJECT_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }
}
