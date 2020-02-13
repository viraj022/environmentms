<?php

namespace App\Http\Controllers;

use App\User;
use App\Level;
use App\Attachemnts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttachemntsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        return view('attachements', ['pageAuth' => $pageAuth]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if($pageAuth['is_create']){
            return true;
        }else{
             return false;
        }
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
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function show(Attachemnts $attachemnts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachemnts $attachemnts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachemnts $attachemnts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachemnts  $attachemnts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachemnts $attachemnts)
    {
        //
    }
}
