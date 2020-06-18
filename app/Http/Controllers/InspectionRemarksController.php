<?php

namespace App\Http\Controllers;

use App\InspectionRemarks;
use App\InspectionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InspectionRemarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
               $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (InspectionSession::find($id) !== null) {
                return view('inspection_remarks', ['pageAuth' => $pageAuth, 'id' => $id]);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function show(InspectionRemarks $inspectionRemarks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionRemarks $inspectionRemarks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionRemarks $inspectionRemarks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionRemarks  $inspectionRemarks
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspectionRemarks $inspectionRemarks)
    {
        //
    }
}
