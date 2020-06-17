<?php

namespace App\Http\Controllers;

use App\EnvOfficer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnvOfficerController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        return view('env_officer', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        request()->validate([
            'name' => 'required|unique:zones,name',
            'code' => 'required|unique:zones,code',
        ]);
        if ($pageAuth['is_create']) {
            $zone = new Zone();
            $zone->name = \request('name');
            $zone->code = \request('code');
            $msg = $zone->save();

            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function find($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        if ($pageAuth['is_read']) {
            return zone::findOrFail($id);
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
    public function store($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        if ($pageAuth['is_update']) {
            $zone = zone::findOrFail($id);
            if ($zone->name != \request('name')) {
                request()->validate([
                    'name' => 'required|unique:zones,name'
                ]);
                $zone->name = \request('name');
            }
            if ($zone->code != \request('code')) {
                request()->validate([
                    'code' => 'required|unique:zones,code'
                ]);
                $zone->code = \request('code');
            }
            $msg = $zone->save();

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
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        if ($pageAuth['is_read']) {
            return Zone::get();
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        if ($pageAuth['is_delete']) {
            $zone = zone::findOrFail($id);
            ;
            $msg = $zone->delete();

            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function isNameUnique($name) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));

        if ($pageAuth['is_create']) {
            $raw = Zone::where('name', '=', $name)->first();
            if ($raw === null) {
                return array('id' => 1, 'message' => 'unique');
            } else {
                return array('id' => 1, 'message' => 'notunique');
            }
        }
    }
    public function isCodeUnique($code) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));

        if ($pageAuth['is_create']) {
            $raw = Zone::where('code', '=', $code)->first();
            if ($raw === null) {
                return array('id' => 1, 'message' => 'unique');
            } else {
                return array('id' => 1, 'message' => 'notunique');
            }
        }
    }

}
