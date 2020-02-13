<?php

namespace App\Http\Controllers;

use App\Pradesheeyasaba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PradesheeyasabaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
        return view('pradesheyasaba', ['pageAuth' => $pageAuth]);  
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
     * @param  \App\Pradesheeyasaba  $pradesheeyasaba
     * @return \Illuminate\Http\Response
     */
    public function show(Pradesheeyasaba $pradesheeyasaba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pradesheeyasaba  $pradesheeyasaba
     * @return \Illuminate\Http\Response
     */
    public function edit(Pradesheeyasaba $pradesheeyasaba)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pradesheeyasaba  $pradesheeyasaba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pradesheeyasaba $pradesheeyasaba)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pradesheeyasaba  $pradesheeyasaba
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pradesheeyasaba $pradesheeyasaba)
    {
        //
    }
}
