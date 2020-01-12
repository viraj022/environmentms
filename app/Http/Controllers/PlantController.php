<?php

namespace App\Http\Controllers;

use App\Plant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Level;
use App\ProvincialCouncil;

class PlantController extends Controller
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
        $palnts = $this::getPlants();
        //  return $palnts;
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.plant'));
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
        $plantTypes = array(Plant::BIO => 'Bio Plant', Plant::COMPOST => 'Compost Palnt');
        return view('plant', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'plantTypes' => $plantTypes, 'plants' => $palnts, 'pro' => $province]);
    }
    public function abc()
    {
        $palnts = $this::getPlants();
        //  return $palnts;
        $aUser = Auth::user();
        $provinces = null;
        $pageAuth = $aUser->authentication(config('auth.privileges.plant'));
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
        $plantTypes = array(Plant::BIO => 'Bio Plant', Plant::COMPOST => 'Compost Palnt');
        return view('plant', ['pageAuth' => $pageAuth, 'provinces' => $provinces, 'plantTypes' => $plantTypes, 'plants' => $palnts, 'pro' => $province]);
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
            'type' => 'required|string|max:50',
            'localAuthority' => 'nullable|integer',
        ]);
        $plant = new Plant();
        $plant->name = \request('name');
        $plant->type = \request('type');
        $plant->address = \request('address');
        $plant->contactNo = \request('number');
        $aUser = Auth::user();


        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            if (\request('localAuthority') > 0) {
                $plant->local_authority_id = request('localAuthority');
            }
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            if (\request('localAuthority') > 0) {
                $plant->local_authority_id = request('localAuthority');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Local Authority Required');
            }
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $plant->local_authority_id = $aUser->institute_Id;
        }
        $msg = $plant->save();
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
    public function store(Request $request, $id)
    {
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'address' => 'nullable|max:100',
            'number' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',

        ]);
        $plant = Plant::find($id);
        $plant->name = \request('name');
        $plant->address = \request('address');
        $plant->contactNo = \request('number');
        $msg = $plant->save();
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
     * @param  \App\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
        $palnts = $this::getPlants();
        $pageAuth = $aUser->authentication(config('auth.privileges.plant'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login

            $plant = Plant::findOrFail($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $plant = Plant::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $plant = Plant::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }

        if ($plant == null) {
            abort(404, 'Not Found.');
        } else {

            if ($plant->local_authority_id != null) {
                $localAuthority = $plant->localAuthority;
                $localAuthorityName = $localAuthority['name'];
                $provincialCouncilName = $localAuthority->ProvincialCouncil['name'];
            } else {
                // wma plant
                $localAuthorityName = null;
                $provincialCouncilName = null;
            }
            return view('plantUpdate', ['pageAuth' => $pageAuth, 'plant' => $plant, 'plants' => $palnts, 'laName' => $localAuthorityName, 'pcName' => $provincialCouncilName]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plant $plant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.plant'));
        if ($aUser->roll->level->name == Level::NATIONAL) {
            // national level login
            $plant = Plant::find($id);
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            // provincial level login
            $plant = Plant::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->where('id', $id)->first();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            // local level login
            $plant = Plant::findOrFail($id)->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->where('id', $id)->first();
        }
        if ($plant == null) {
            // show plant nofound 
            abort(404, 'Not Found.');
        } else {

            $plant->delete();
            return redirect('plant');
        }
    }

    public function getPlants()
    {
        $aUser = Auth::user();
        if ($aUser->roll->level->name == Level::NATIONAL) {
            return Plant::all();
        } else if ($aUser->roll->level->name == Level::PROVINCIAL) {
            return Plant::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('provincial_council_id', $id);
            })->get();
        } else if ($aUser->roll->level->name == Level::LOCAL) {
            return Plant::with('localAuthority')->whereHas('localAuthority', function ($query) {
                $id = Auth::user()->institute->id;
                $query->where('id', $id);
            })->get();
        }
    }
}
