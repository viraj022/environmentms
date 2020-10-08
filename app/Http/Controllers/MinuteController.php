<?php

namespace App\Http\Controllers;

use App\Client;
use App\Minute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MinutesRepository;
use App\Repositories\CommitteeRepository;

class MinuteController extends Controller
{
    private  $minutesRepository;

    public function __construct(MinutesRepository $minutesRepository)
    {
        $this->middleware(['auth:api']);
        $this->minutesRepository = $minutesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function show($id)
    {
        return $this->minutesRepository->all($id);
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
