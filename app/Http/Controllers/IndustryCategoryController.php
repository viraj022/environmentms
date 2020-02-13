<?php

namespace App\Http\Controllers;

use App\IndustryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndustryCategoryController extends Controller
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
        return view('industry_category', ['pageAuth' => $pageAuth]);  
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
     * @param  \App\IndustryCategory  $industryCategory
     * @return \Illuminate\Http\Response
     */
    public function show(IndustryCategory $industryCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IndustryCategory  $industryCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(IndustryCategory $industryCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IndustryCategory  $industryCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IndustryCategory $industryCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IndustryCategory  $industryCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(IndustryCategory $industryCategory)
    {
        //
    }
}
