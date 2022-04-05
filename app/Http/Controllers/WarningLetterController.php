<?php

namespace App\Http\Controllers;

use App\WarningLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class WarningLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('warning_letter', ['pageAuth' => $pageAuth]);
    }

    public function warnLetView($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $warn_letter = WarningLetter::where('id', $id)->with('client')->first();
        return view('warn_letter_view', ['pageAuth' => $pageAuth, 'warn_let_data' => $warn_letter]);
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
        $current_date = Carbon::parse(date("Y-m-d"));
        $expired_date = Carbon::parse($request->expired_date);
        $user = Auth::user()->id;
        $client_id = $request->client_id;
        $expired_days = $current_date->diffInDays($expired_date);

        $warning_letter = WarningLetter::create([
            "letter_generated_date" =>  $current_date,
            "user_id" => $user,
            "client_id" => $client_id,
            "expired_days" => $expired_days
        ]);

        if ($warning_letter == true) {
            return array('status' => 1, 'message' => 'Successfully saved the warning letter');
        } else {
            return array('status' => 0, 'message' => 'Warning letter saving is unsuccessful');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WarningLetter  $warningLetter
     * @return \Illuminate\Http\Response
     */
    public function show(WarningLetter $warningLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WarningLetter  $warningLetter
     * @return \Illuminate\Http\Response
     */
    public function edit(WarningLetter $warningLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WarningLetter  $warningLetter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WarningLetter $warningLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WarningLetter  $warningLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(WarningLetter $warningLetter)
    {
        //
    }
}
