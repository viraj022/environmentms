<?php

namespace App\Http\Controllers;

use App\Client;
use App\Rules\contactNo;
use App\Rules\nationalID;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientController extends Controller
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
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('client_space', ['pageAuth' => $pageAuth]);
    }
    public function allClientsindex()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('all_clients', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'contact_no' => ['required', new contactNo],
            'email' => 'nullable|sometimes',
            'nic' => ['sometimes', 'required', 'unique:clients', new nationalID],
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
            $msg = $client->save();
            if ($msg) {
                return array('id' => 1, 'message' => 'true','nic' => $client->nic);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
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
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_delete']) {
            $client = Client::findOrFail($id);
            $msg =  $client->delete();
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function findClient_by_nic($nic)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            //    PaymentType::get();
            return Client::where('nic', '=', $nic)
                ->get();
        } else {
            abort(401);
        }
    }
    public function findClient_by_id($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            //    PaymentType::get();
            return Client::find($id);
        } else {
            abort(401);
        }
    }
}
