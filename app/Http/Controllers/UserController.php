<?php

namespace App\Http\Controllers;

use App\Level;
use App\Privilege;
use App\Helpers\LogActivity;
use App\Rules\contactNo;
use App\Rules\nationalID;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $users = User::get();
        $level = Level::get();
        $pageAuth = $user->authentication(config('auth.privileges.userCreate'));
        return view('user', ['levels' => $level, 'users' => $users, 'pageAuth' => $pageAuth]);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        //       dd(request()->all());

        \DB::transaction(function () {
            $msg = false;
            request()->validate([
                'firstName' => 'required|max:50|string',
                'lastName' => 'required|max:50|string',
                'userName' => 'required|max:50|string|unique:users,user_name',
                'address' => 'sometimes|max:100',
                'contactNo' => ['nullable', new contactNo],
                'email' => 'sometimes|nullable|email',
                'nic' => ['sometimes', 'nullable', 'unique:users', new nationalID],
                'roll' => 'integer|required',
                'password' => 'required|confirmed|min:6',
                // 'institute' => 'required|integer',

            ]);
            $user = new User();
            $user->user_name = request('userName');
            $user->first_name = request('firstName');
            $user->last_name = request('lastName');
            $user->address = request('address');
            $user->contact_no = request('contactNo');
            $user->email = request('email');
            $user->nic = request('nic');
            $user->roll_id = request('roll');
            $user->password = Hash::make(request('password'));
            $user->api_token = Str::random(80);
            // if (request('level') == '1') {
            //     // set institute id to null
            // } else {
            //     $user->institute_id = request('institute');
            // }

            $msg = $user->save();

            if ($msg) {
                LogActivity::addToLog('Save User : UserController',$user);            
                return array('id' => 1, 'message' => 'true');
            } else {
                LogActivity::addToLog('Save User Fail : UserController',$user);
                return array('id' => 0, 'message' => 'false');
            }
      
            //         ($user);
            UserController::PrevilagesAdd($user);
        });
        return redirect()
            ->back()
            ->with('success', 'Ok');
          
            
    }

    public function edit(Request $request, $id)
    {
        $aUser = Auth::user();

        $user = User::findOrFail($id);

        $level = $user->roll->level;
        $privileges = Privilege::get();
        $roles = Level::find($user->roll->level_id)->rolls;
        $activity = array(
            'ACTIVE' => User::ACTIVE,
            'INACTIVE' => User::INACTIVE,
            'ARCHIVED' => User::ARCHIVED,
        );
        $pageAuth = $aUser->authentication(config('auth.privileges.userCreate'));

        return view('user_update', ['level' => $level, 'user' => $user, 'privileges' => $privileges, 'roles' => $roles, 'activitys' => $activity, 'pageAuth' => $pageAuth]);
    }

    public function PrevilagesAdd($user)
    {
        $privileges = $user->roll->privileges;
        //        dd($privileges);
        foreach ($privileges as $value) {
            //           echo $value['id'] . request('roll_id') . "</br>";
            $user->privileges()->attach(
                $value['id'],
                [
                    'is_read' => $value['pivot']['is_read'],
                    'is_create' => $value['pivot']['is_create'],
                    'is_update' => $value['pivot']['is_update'],
                    'is_delete' => $value['pivot']['is_delete'],
                ]
            );
        }
    }

    public function PrevilagesAddById(Request $request, $id)
    {
        $privileges = $request->all()['pre'];
        //        dd($privileges);
        $user = User::findOrFail($id);
        request()->validate([
            'role' => 'integer|required',
        ]);
        $user->roll_id = request('role');
        $user->save();
        $user->privileges()->detach();
        foreach ($privileges as $value) {
            $user->privileges()->attach(
                $value['id'],
                [
                    'is_read' => $value['is_read'],
                    'is_create' => $value['is_create'],
                    'is_update' => $value['is_update'],
                    'is_delete' => $value['is_delete'],
                ]
            );
        }
        return array('id' => '1', 'msg' => 'ok');
    }

    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //        request()->validate([
        //            'firstName' => 'required|max:50|alpha',
        //            'lastName' => 'required|max:50|alpha',
        //            'userName' => 'required|max:50|alpha_dash|unique:users,user_name',
        //            'address' => 'max:100|alpha',
        //            'contactNo' => 'max:12',
        //            'email' => 'email',
        //            'nic' => 'max:12|unique:users,3'
        //        ]);

        //        dd($user);
        $user->user_name = request('userName');
        $user->first_name = request('firstName');
        $user->last_name = request('lastName');
        $user->address = request('address');
        $user->contact_no = request('contactNo');
        $user->email = request('email');
        $user->nic = request('nic');
        $msg = $user->save();


        if ($msg) {
            LogActivity::addToLog('Update User Done: UserController',$user);          
 
        } else {
            LogActivity::addToLog('Update User Fail : UserController',$user);
        }


        if ($msg) {
            return redirect()
                ->back()
                ->with('success', 'Ok');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error');
        }
        LogActivity::addToLog('Assign User Privileges', $user);
    }

    public function storePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        request()->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $user->password = Hash::make(request('password'));
        $msg = $user->save();


        if ($msg) {
            LogActivity::addToLog('Store Password Done: UserController',$user);          
 
        } else {
            LogActivity::addToLog('Store Password Fail: UserController',$user);
        }

        if ($msg) {
            return redirect()
                ->back()
                ->with('success', 'Ok');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error');
        }
    }

    public function activeStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //        return $request;
        //        request()->validate([
        //            'password' => 'required|confirmed|min:6'
        //        ]);
        // need to write a validation rule to recstict input
        //        return $request['status'];
        switch ($request['status']) {
            case 'ACTIVE':
                $user->activeStatus = User::ACTIVE;
                return array('id' => 1, 'msg' => 'success');
                break;
            case 'INACTIVE':
                $user->activeStatus = User::INACTIVE;
                return array('id' => 1, 'msg' => 'success');
                break;
            case 'ARCHIVED':
                $user->activeStatus = User::ARCHIVED;
                return array('id' => 1, 'msg' => 'success');
                break;
            default:
                return array('id' => 2, 'msg' => 'invalid Input');
        }
        $user->save();
    }

    public function previlagesById($id)
    {
        $user = User::findOrFail($id);
        return $user->privileges;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $msg = $user->delete();
        $users = User::with('roll')->get();
        $level = Level::get();
        $Auser = Auth::user();
        $pageAuth = $Auser->authentication(config('auth.privileges.userCreate'));
        return view('user', ['levels' => $level, 'users' => $users, 'pageAuth' => $pageAuth]);

 


        if ($msg) {
            LogActivity::addToLog('Delete Done: UserController',$user);          
 
        } else {
            LogActivity::addToLog('Delete fail: UserController',$user);
        }
    }

    public function logout()
    {
        Auth::logout();
        return view('auth.login');
        //        $this->middleware('auth');
    }
    public function myProfile()
    {
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.userCreate'));
        return view('my_profile', ['user' => $aUser, 'pageAuth' => $pageAuth]);
    }
    public function changeMyPass()
    {
        $aUser = Auth::user();
        request()->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $aUser->password = Hash::make(request('password'));
        $msg = $aUser->save();

        if ($msg) {
            LogActivity::addToLog('changeMyPass Done: UserController',$aUser);          
 
        } else {
            LogActivity::addToLog('changeMyPass fail: UserController',$aUser);
        }

        if ($msg) {
            return redirect()
                ->back()
                ->with('success', 'Ok');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error');
        }
    }

    public function getDeletedUser()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.userCreate'));
        return User::onlyTrashed()->get();
    }

    public function activeDeletedUser($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.userCreate'));

        $msg = User::withTrashed()->find($id)->restore();

        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }




}
