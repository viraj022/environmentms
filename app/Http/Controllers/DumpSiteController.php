<?php

namespace App\Http\Controllers;

use App\DumpSite;
use App\Level;
use App\ProvincialCouncil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DumpSiteController extends Controller
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
        $dumpSites = $this::getDumpSites();
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.userCreate'));
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

        return view('dumpsite', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'dumpSites' => $dumpSites, 'pro' => $province]);
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
            'localAuthority' => 'nullable|integer',
        ]);
        $dumpSite = new DumpSite();
        $dumpSite->name = \request('name');
        $dumpSite->address = \request('address');
        $dumpSite->contactNo = \request('number');
        $aUser = Auth::user();

        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            if (\request('localAuthority') > 0) {
                $dumpSite->local_authority_id = request('localAuthority');
            }
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            if (\request('localAuthority') > 0) {
                //! possible security issue transfer station must have a local authority other wise it is considered as wma transfer station
                $dumpSite->local_authority_id = request('localAuthority');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Local Authority Required');
            }
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $dumpSite->local_authority_id = $aUser->institute_Id;
        }
        $msg = $dumpSite->save();
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
        $dumpsite = DumpSite::find($id);
        $dumpsite->name = \request('name');
        $dumpsite->address = \request('address');
        $dumpsite->contactNo = \request('number');
        $msg = $dumpsite->save();
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
     * @param  \App\DumpSite  $dumpSite
     * @return \Illuminate\Http\Response
     */
    public function show(DumpSite $dumpSite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DumpSite  $dumpSite
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
        $dumpSites = $this::getDumpSites();
        $pageAuth = $aUser->authentication(config('auth.privileges.dumpsite'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            $dumpSite = DumpSite::findOrFail($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $dumpSite = DumpSite::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $dumpSite = DumpSite::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }

        if ($dumpSite == null) {
            abort(404, 'Not Found.');
        } else {

            if ($dumpSite->local_authority_id != null) {
                $localAuthority = $dumpSite->localAuthority;
                $localAuthorityName = $localAuthority['name'];
                $provincialCouncilName = $localAuthority->ProvincialCouncil['name'];
            } else {
                // wma plant
                $localAuthorityName = null;
                $provincialCouncilName = null;
            }
            return view('dumpsiteUpdate', ['pageAuth' => $pageAuth, 'dumpSites' => $dumpSites, 'dumpSite' => $dumpSite, 'laName' => $localAuthorityName, 'pcName' => $provincialCouncilName]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DumpSite  $dumpSite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DumpSite $dumpSite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DumpSite  $dumpSite
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            //* national level login
            $dumpSite = DumpSite::find($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $dumpSite = DumpSite::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            //* local level login
            $dumpSite = DumpSite::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }
        if ($dumpSite == null) {
            //* show plant not found
            abort(404, 'Not Found.');
        } else {

            $dumpSite->delete();
            return redirect('dumpsite');
        }
    }

    public function getDumpSites()
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            return DumpSite::all();
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            return DumpSite::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->get();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return DumpSite::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->get();
        }
    }
}
