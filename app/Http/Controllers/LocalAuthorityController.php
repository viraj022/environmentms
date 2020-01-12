<?php

namespace App\Http\Controllers;

use App\Level;
use App\LocalAuthority;
use App\ProvincialCouncil;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalAuthorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $localAuthorities = LocalAuthority::all();
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.localAuthority'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            $provinces = ProvincialCouncil::all();
            //            dd($provinces)
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            $provinces = null;
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return abort(403);
        }
        $laTypes = array(LocalAuthority::MUNICIPAL => 'Municipal Council', LocalAuthority::URBAN => 'Urban Council', LocalAuthority::PRADESHIYA => 'Pradeshiya Sabha', LocalAuthority::MEGA => 'Mega Police');
        return view('local_authority_create', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'laTypes' => $laTypes, 'localAuthorities' => $localAuthorities]);
    }


    public function edit($id)
    {
        $localAuthorities = LocalAuthority::all();
        $localAuthority = LocalAuthority::with('ProvincialCouncil')->findOrFail($id);
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.localAuthority'));
        return view('local_authority_update', ['pageAuth' => $pageAuth, 'localAuthority' => $localAuthority, 'localAuthorities' => $localAuthorities]);
    }

    public function create()
    {
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'code' => 'nullable|string|max:50',
            'address' => 'sometimes|max:100',
            'laType' => 'string|required',
            'province' => 'integer|sometimes',
        ]);
        $localAuthority = new LocalAuthority();
        $localAuthority->name = \request('name');
        $localAuthority->type = \request('laType');
        $localAuthority->address = \request('address');
        $localAuthority->laCode = \request('code');
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            $localAuthority->provincial_council_id = \request('province');
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            //            dd($aUser->ininstitute);
            $localAuthority->provincial_council_id = $aUser->institute['id'];
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return abort(403);
        }
        $msg = $localAuthority->save();
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

    public function store($id)
    {
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'code' => 'nullable|string|max:50',
            'address' => 'sometimes|max:100'
        ]);
        $localAuthority = LocalAuthority::findOrFail($id);
        $localAuthority->name = \request('name');
        $localAuthority->address = \request('address');
        $localAuthority->laCode = \request('code');
        $msg = $localAuthority->save();
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

    public function delete($id)
    {
        $localAuthority = LocalAuthority::findOrFail($id);
        $localAuthority->delete();
        $this::index();
        $localAuthorities = LocalAuthority::all();
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.localAuthority'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            $provinces = ProvincialCouncil::all();
            //            dd($provinces)
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            $provinces = null;
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return abort(403);
        }
        $laTypes = array(LocalAuthority::MUNICIPAL => 'Municipal Council', LocalAuthority::URBAN => 'Urban Council', LocalAuthority::PRADESHIYA => 'Pradeshiya Sabha', LocalAuthority::MEGA => 'Mega Police');
        return view('local_authority_create', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'laTypes' => $laTypes, 'localAuthorities' => $localAuthorities]);
    }

    public function getLocalAuthorityByProvince($id)
    {

        $province = ProvincialCouncil::find($id);
        if ($province != null) {
            return $province->localAuthority;
        } else {
            return array();
        }
    }
}
