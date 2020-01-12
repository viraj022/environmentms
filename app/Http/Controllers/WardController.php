<?php

namespace App\Http\Controllers;

use App\LocalAuthority;
use App\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'local']);
    }
    public function index()
    {

        $aUser = Auth::user();
        // return $aUser->institute_id;
        $wards = LocalAuthority::find($aUser->institute_Id)->wards;
        $pageAuth = $aUser->authentication(config('auth.privileges.ward'));
        return view('ward', ['pageAuth' => $pageAuth, 'wards' => $wards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aUser = Auth::user();
        // return $aUser->institute_Id;
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'code' => 'nullable|string|max:50',
        ]);
        $ward = new Ward();
        $ward->name = \request('name');
        $ward->code = \request('code');
        $ward->local_authority_id = $aUser->institute_Id;
        $msg = $ward->save();
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
        $aUser = Auth::user();
        // return $aUser->institute_Id;
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'code' => 'nullable|string|max:50',
        ]);
        $ward = Ward::findOrFail($id);
        if ($ward->local_authority_id === $aUser->institute_Id) {
            $ward->name = \request('name');
            $ward->code = \request('code');
            $ward->local_authority_id = $aUser->institute_Id;
            $msg = $ward->save();
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
        } else {
            abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function show(Ward $ward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
        $ward = Ward::findOrFail($id);
        if ($ward->local_authority_id === $aUser->institute_Id) {
            $wards = LocalAuthority::find($aUser->institute_Id)->wards;
            $pageAuth = $aUser->authentication(config('auth.privileges.ward'));
            return view('ward_update', ['pageAuth' => $pageAuth, 'ward' => $ward, 'wards' => $wards]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ward $ward)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ward  $ward
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        $ward = Ward::findOrFail($id);
        if ($ward->local_authority_id === $aUser->institute_Id) {
            $ward->delete();
            return redirect('ward');
        } else {
            abort(404);
        }
    }
}
