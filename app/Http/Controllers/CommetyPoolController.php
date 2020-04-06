<?php

namespace App\Http\Controllers;

use App\CommetyPool;
use App\Rules\contactNo;
use App\Rules\nationalID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommetyPoolController extends Controller
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
    public function index() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.committeePool'));
        return view('comty_pool', ['pageAuth' => $pageAuth]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.committeePool'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'first_name' => 'required',
                'last_name' => 'sometimes|nullable',
                'address' => 'sometimes|nullable',
                'email' => 'sometimes|nullable',
                'contact_no' => ['nullable', 'sometimes', new contactNo],
                'nic' => ['sometimes', 'nullable', 'unique:commety_pools', new nationalID],
                // 'password' => 'required',
            ]);
            $aUser = Auth::user();
            $pageAuth = $aUser->authentication(config('auth.privileges.vehicle'));
            $CommetyPool = new CommetyPool();
            $CommetyPool->first_name = request('first_name');
            $CommetyPool->last_name = request('last_name');
            $CommetyPool->nic = request('nic');
            $CommetyPool->address = request('address');
            $CommetyPool->email = request('email');
            $CommetyPool->contact_no = \request('contact_no');

            $msg = $CommetyPool->save();
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
    public function store($id)
    {
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.committeePool'));
        $commetyPool = CommetyPool::find($id);

        if ($pageAuth['is_update']) {
            request()->validate([
                'first_name' => 'required',
                'last_name' => 'sometimes|nullable',
                'address' => 'sometimes|nullable',
                'email' => 'sometimes|nullable',
                'contact_no' => ['nullable', 'sometimes', new contactNo],
                'nic' => ['sometimes', 'nullable', 'unique:commety_pools,nic,' . $commetyPool->id, new nationalID],
            ]);
            $aUser = Auth::user();
            $pageAuth = $aUser->authentication(config('auth.privileges.vehicle'));
            $commetyPool->first_name = request('first_name');
            $commetyPool->last_name = request('last_name');
            $commetyPool->nic = request('nic');
            $commetyPool->address = request('address');
            $commetyPool->address = request('email');
            $commetyPool->contact_no = \request('contact_no');
            $msg = $commetyPool->save();

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
     * @param  \App\CommetyPool  $commetyPool
     * @return \Illuminate\Http\Response
     */
    public function show(CommetyPool $commetyPool)
    {

        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.committeePool'));
        if ($pageAuth['is_read']) {
            return CommetyPool::get();
        } else {
            abort(401);
        }
    }

    public function find($id)
    {

        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.committeePool'));
        if ($pageAuth['is_read']) {
            return CommetyPool::find($id);
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommetyPool  $commetyPool
     * @return \Illuminate\Http\Response
     */
    public function edit(CommetyPool $commetyPool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommetyPool  $commetyPool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommetyPool $commetyPool)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommetyPool  $commetyPool
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.committeePool'));
        if ($pageAuth['is_delete']) {
        $commetyPool = CommetyPool::find($id);
       $msg = $commetyPool->delete(); 
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
        } else {
            abort(401);
        }
    }
}
