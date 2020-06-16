<?php

namespace App\Http\Controllers;

use App\BusinessScale;
use Illuminate\Http\Request;

class BusinessScaleController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\BusinessScale  $businessScale
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessScale $businessScale)
    {
      return  BusinessScale::get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessScale  $businessScale
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessScale $businessScale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessScale  $businessScale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessScale $businessScale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessScale  $businessScale
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessScale $businessScale)
    {
        //
    }
}
