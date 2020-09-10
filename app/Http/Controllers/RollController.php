<?php

namespace App\Http\Controllers;

use App\Level;
use App\Privilege;
use App\Roll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class RollController extends Controller
{
    public function index()
    {
        $rolls = Roll::get();
        $level = Level::get();
        $privileges = Privilege::get();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.userRole'));
        return view('rolls', ['privileges' => $privileges, 'levels' => $level, 'pageAuth' => $pageAuth]);
    }

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function create()
    {
        request()->validate([
            'roll' => ['required', 'string'],
            'level' => ['required', 'numeric'],
        ]);
        $roll = new Roll();
        $roll->name = request('roll');
        $roll->level_id = request('level');
        $msg = $roll->save();
        if ($msg) {
            LogActivity::addToLog('roll added',$roll); 
            return redirect()
                ->back()
                ->with('success', 'Ok');
        } else {
            LogActivity::addToLog('Fail to add  roll',$roll);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error');
        }


           

    
  
     
        
    }
    public function store($id)
    {

        request()->validate([
            'roll' => ['required', 'string'],
        ]);
        $roll = Roll::findOrFail($id);
        $roll->name = request('roll');
        $msg = $roll->save();

        if ($msg) {
            LogActivity::addToLog('roll updated',$roll);            
            return array('id' => 1, 'message' => 'true');
        } else {
            LogActivity::addToLog('Fail to update roll',$roll);
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getRollPrevilagesById($id)
    {
        $roll = Roll::findOrFail($id);
        return $roll->privileges;
    }

    public function PrevilagesAdd()
    {
        \DB::transaction(function () {
            // dd(request('pre'));
            $roll = ROll::findOrFail(request('roll_id'));
            $roll->privileges()->detach();
            $status = true;
            foreach (request('pre') as $value) {

                $roll->privileges()->attach(
                    $value['id'],
                    [
                        'is_read' => $value['is_read'],
                        'is_create' => $value['is_create'],
                        'is_update' => $value['is_update'],
                        'is_delete' => $value['is_delete'],
                    ]
                );
            }
        });
        return array('id' => '1', 'msg' => 'true');
    }

    public function destroy($id)
    {
        try {

            $roll = ROll::findOrFail($id);
            $msg = $roll->delete();

            if ($msg) {
                LogActivity::addToLog('roll deleted',$roll);            
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('Fail to delete roll',$roll);
                return array('id' => 0, 'message' => 'false');
            }

        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[0] == 23000) {
                return response(array('id' => 3, 'mgs' => 'Cannot delete foreign key constraint fails'), 200)
                    ->header('Content-Type', 'application/json');
            } else {
                return response(array('id' => 3, 'mgs' => 'Internal Server Error'), 500)
                    ->header('Content-Type', 'application/json');
            }
        }
    }
}
