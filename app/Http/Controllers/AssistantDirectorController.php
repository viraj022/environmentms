<?php

namespace App\Http\Controllers;

use App\User;
use App\AssistantDirector;
use App\EnvironmentOfficer;
use App\Level;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssistantDirectorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        return view('assistant_director', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        request()->validate([
            'user_id' => 'required',
            'zone_id' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            if ($this->checkAssistantDirector(\request('user_id'))) {
                $assistantDirector = new AssistantDirector();
                $assistantDirector->user_id = \request('user_id');
                $assistantDirector->zone_id = \request('zone_id');
                $assistantDirector->active_status = '1';
                $msg = $assistantDirector->save();
                
         

                if ($msg) {
                    return array('id' => 1, 'message' => 'true');
                    LogActivity::addToLog('New assistant director added',$assistantDirector);
                } else {
                    return array('id' => 0, 'message' => 'false');
                    LogActivity::addToLog('Fail to add new  assistant director',$assistantDirector);
                }
            } else {
                return array('message' => 'Custom Validation unprocessable entry', 'errors' => array('user_id' => 'user is already already assigned as an active assistant director'));
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
    public function store($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        request()->validate([
            'user_id' => 'required',
            'zone_id' => 'required',
        ]);
        if ($pageAuth['is_update']) {
            $assistantdirector = AssistantDirector::findOrFail($id);
            $assistantdirector->user_id = \request('user_id');
            $assistantdirector->zone_id = \request('zone_id');
            $msg = $assistantdirector->save();
            if ($msg) {              
                LogActivity::addToLog('Assistant director id: '.$id .' updated',$assistantdirector);
                return array('id' => 1, 'message' => 'true');
            } else {                
                LogActivity::addToLog('Fail to update Assistant director id: '.$id,$assistantdirector);
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function UnActiveAssistantDirector($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        //  request()->validate([
        //     'user_id' => 'required',
        //     'zone_id' => 'required',
        // ]);
        if ($pageAuth['is_update']) {
            $assistantdirector = AssistantDirector::findOrFail($id);
            $assistantdirector->active_status = '0';
            $msg = $assistantdirector->save();
            if ($msg) {
                LogActivity::addToLog('Un Active Assistant director id: '.$id ,$assistantdirector);
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('Fail to Un Active  Assistant director id: '.$id,$assistantdirector);
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function show(AssistantDirector $assistantDirector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function edit(AssistantDirector $assistantDirector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssistantDirector $assistantDirector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        //  request()->validate([
        //     'user_id' => 'required',
        //     'zone_id' => 'required',
        // ]);
        if ($pageAuth['is_update']) {
            $assistantdirector = AssistantDirector::findOrFail($id);
            $assistantdirector->active_status = '0';
            $msg = $assistantdirector->save();
            if ($msg) {
                LogActivity::addToLog('Assistant director id: '.$id .'deleted ',$assistantdirector);
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('Fail to deleete Assistant director id: '.$id,$assistantdirector);
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    //get allUser not in 
    public function getAllUsersNotInAssistantDirector()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {
            $assistantDirectors = AssistantDirector::where('active_status', '1')->select('user_id')->get();
            $environmentOfficers = EnvironmentOfficer::where('active_status', '1')->select('user_id as id')->get();
           // LogActivity::addToLog('Request to Get all users not in assistantDirector',$assistantDirectors);
            //return $allAssistantDerectors;
            return User::whereHas('roll.level', function ($queary) {
                $queary->where('name', Level::ASSI_DIRECTOR);
            })->wherenotin('id', $assistantDirectors)->wherenotin('id', $environmentOfficers)->get();

            //return AssistantDirector::get(); 
        } else {
          //  LogActivity::addToLog('Fails to Get all users not in assistantDirector',null);
            abort(401);
        }
    }
    //end get allUser not in 




    //get all active_AssistantDirector
    public function getAll_active_AssistantDirector()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {

    //        LogActivity::addToLog('Request to Get all active assistantDirector',null);
            //    PaymentType::get();
            return AssistantDirector::join('users', 'assistant_directors.user_id', '=', 'users.id')
                ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
                ->where('assistant_directors.active_status', '=', '1')
                ->select('assistant_directors.id', 'users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name')
                ->get();
        } else {
           // LogActivity::addToLog('Fails to Get all active assistantDirector',null);
            abort(401);
        }
    }


    public function assistantDirectorByZone($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {

            return AssistantDirector::join('users', 'assistant_directors.user_id', '=', 'users.id')
                ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
                ->where('assistant_directors.active_status', '=', '1')
                ->where('zones.id', '=', $id)
                ->select('users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name')
                ->get();
        } else {
            abort(401);
        }
    }





    //get a AssistantDirector
    public function get_a_AssistantDirector($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {

            //    PaymentType::get();
            return AssistantDirector::join('users', 'assistant_directors.user_id', '=', 'users.id')
                ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
                ->where('assistant_directors.id', '=', $id)
                ->select('assistant_directors.id', 'users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name', 'assistant_directors.active_status as active_status')
                ->first();
        } else {
            abort(401);
        }
    }

    //end get a AssistantDirector

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

    public function getAssistanceDirectorsByLevel()
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = AssistantDirector::with('user')->where('active_status', 1)->get();
            // dd($data->toArray());
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = AssistantDirector::with('user')->where('user_id', $user->id)->where('active_status', 1)->get();
            // dd($data);
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $data = AssistantDirector::with('user')->where('id', EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first()->assistant_director_id)->get();
        }
        return $data;
    }

    public function getAssistanceDirectorFile()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
    }
}//end calss
