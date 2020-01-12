<?php

namespace App\Http\Controllers;

use App\TransferStation;
use Illuminate\Http\Request;
use App\Level;
use App\ProvincialCouncil;
use Illuminate\Support\Facades\Auth;

class TransferStationController extends Controller
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

        $transferStations = $this::getTransferStations();
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.transferStation'));
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

        return view('transferStation', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'transferStations' => $transferStations, 'pro' => $province]);
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
        $transferStation = new TransferStation();
        $transferStation->name = \request('name');
        $transferStation->address = \request('address');
        $transferStation->contactNo = \request('number');
        $aUser = Auth::user();

        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            if (\request('localAuthority') > 0) {
                $transferStation->local_authority_id = request('localAuthority');
            }
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            if (\request('localAuthority') > 0) {
                //! possible security issue transfer station must have a local authority other wise it is considered as wma transfer station
                $transferStation->local_authority_id = request('localAuthority');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Local Authority Required');
            }
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $transferStation->local_authority_id = $aUser->institute_Id;
        }
        $msg = $transferStation->save();
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
        $transferStation = TransferStation::find($id);
        $transferStation->name = \request('name');
        $transferStation->address = \request('address');
        $transferStation->contactNo = \request('number');
        $msg = $transferStation->save();
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
     * @param  \App\transferStation  $transferStation
     * @return \Illuminate\Http\Response
     */
    public function show(transferStation $transferStation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\transferStation  $transferStation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
        $transferStations = $this::getTransferStations();
        $pageAuth = $aUser->authentication(config('auth.privileges.transferStation'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            $transferStation = TransferStation::findOrFail($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $transferStation = TransferStation::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $transferStation = TransferStation::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }

        if ($transferStation == null) {
            abort(404, 'Not Found.');
        } else {

            if ($transferStation->local_authority_id != null) {
                $localAuthority = $transferStation->localAuthority;
                $localAuthorityName = $localAuthority['name'];
                $provincialCouncilName = $localAuthority->ProvincialCouncil['name'];
            } else {
                // wma plant
                $localAuthorityName = null;
                $provincialCouncilName = null;
            }
            return view('transferStationUpdate', ['pageAuth' => $pageAuth, 'transferStation' => $transferStation, 'transferStations' => $transferStations, 'laName' => $localAuthorityName, 'pcName' => $provincialCouncilName]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\transferStation  $transferStation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transferStation $transferStation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\transferStation  $transferStation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            $transferStation = TransferStation::find($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $transferStation = TransferStation::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $transferStation = TransferStation::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }
        if ($transferStation == null) {
            // show plant nofound 
            abort(404, 'Not Found.');
        } else {

            $transferStation->delete();
            return redirect('transfer_station');
        }
    }
    public function getTransferStations()
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            return TransferStation::all();
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            return TransferStation::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->get();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return TransferStation::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->get();
        }
    }
}
