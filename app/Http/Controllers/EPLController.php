<?php

namespace App\Http\Controllers;

use App\EPL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EPLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {        
            return view('epl_register', ['pageAuth' => $pageAuth,'id'=>$id]);
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
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function show(EPL $ePL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function edit(EPL $ePL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EPL $ePL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function destroy(EPL $ePL)
    {
        //
    }
}
