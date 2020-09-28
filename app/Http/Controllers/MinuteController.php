<?php

namespace App\Http\Controllers;

use App\Minute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinuteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return array(
            array(
                "type" => "EPL",
                "date" => "2020-01-01",
                "minute_object" =>  array(
                    "minute_description" => "Text minutes",
                    "situation" => "situvation",
                    "user" => array(Auth::user())
                )

            ),
            array(
                "type" => "EPL",
                "date" => "2020-01-01",
                "minute_object" =>  array(
                    "minute_description" => "Text minutes",
                    "situation" => "situvation",
                    "user" => array(Auth::user())
                )

            )
        );
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
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function show(Minute $minute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function edit(Minute $minute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Minute $minute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Minute  $minute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Minute $minute)
    {
        //
    }
}
