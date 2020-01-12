<?php

namespace App\Http\Controllers;

use App\Level;
use App\SamapthKendraya;
use App\ProvincialCouncil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SamapthKendrayaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sampathkendrayas = $this::getSampathKendrays();
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.sampath'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            $provinces = ProvincialCouncil::all();
            $province = null;
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            $provinces = null;
            $province = $aUser->institute;
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            $provinces = null;
            $province = null;
        }

        return view('sampath', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'sampathkendrayas' => $sampathkendrayas, 'pro' => $province]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'address' => 'nullable|max:100',
            'number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'localAuthority' => 'integer',
        ]);
        $samapthKendraya = new SamapthKendraya();
        $samapthKendraya->name = \request('name');
        $samapthKendraya->address = \request('address');
        $samapthKendraya->contactNo = \request('number');
        $aUser = Auth::user();

        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            if (\request('localAuthority') > 0) {
                $samapthKendraya->local_authority_id = request('localAuthority');
            }
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            if (\request('localAuthority') > 0) {
                //! possible security issue transfer station must have a local authority other wise it is considered as wma transfer station
                $samapthKendraya->local_authority_id = request('localAuthority');
            }
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $samapthKendraya->local_authority_id = $aUser->institute_Id;
        }
        $msg = $samapthKendraya->save();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'address' => 'nullable|max:100',
            'number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

        ]);
        $samapthKendraya = SamapthKendraya::find($id);
        $samapthKendraya->name = \request('name');
        $samapthKendraya->address = \request('address');
        $samapthKendraya->contactNo = \request('number');
        $msg = $samapthKendraya->save();
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

    /**
     * Display the specified resource.
     *
     * @param  \App\SamapthKendraya  $samapthKendraya
     * @return \Illuminate\Http\Response
     */
    public function show(SamapthKendraya $samapthKendraya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SamapthKendraya  $samapthKendraya
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
        $sampathkendrayas = $this::getSampathKendrays();
        $pageAuth = $aUser->authentication(config('auth.privileges.sampath'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            $sampathkendraya = SamapthKendraya::findOrFail($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $sampathkendraya = SamapthKendraya::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $sampathkendraya = SamapthKendraya::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }

        if ($sampathkendraya == null) {
            abort(404, 'Not Found.');
        } else {

            if ($sampathkendraya->local_authority_id != null) {
                $localAuthority = $sampathkendraya->localAuthority;
                $localAuthorityName = $localAuthority['name'];
                $provincialCouncilName = $localAuthority->ProvincialCouncil['name'];
            } else {
                // wma plant
                $localAuthorityName = null;
                $provincialCouncilName = null;
            }
            return view('sampathUpdate', ['pageAuth' => $pageAuth, 'sampathkendrayas' => $sampathkendrayas, 'sampathkendraya' => $sampathkendraya, 'laName' => $localAuthorityName, 'pcName' => $provincialCouncilName]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SamapthKendraya  $samapthKendraya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SamapthKendraya $samapthKendraya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SamapthKendraya  $samapthKendraya
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            //* national level login
            $samapthKendraya = SamapthKendraya::find($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $samapthKendraya = SamapthKendraya::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            //* local level login
            $samapthKendraya = SamapthKendraya::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }
        if ($samapthKendraya == null) {
            //* show plant not found 
            abort(404, 'Not Found.');
        } else {

            $samapthKendraya->delete();
            return redirect('sampath');
        }
    }
    public function getSampathKendrays()
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            return SamapthKendraya::all();
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            return SamapthKendraya::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->get();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return SamapthKendraya::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->get();
        }
    }
}
