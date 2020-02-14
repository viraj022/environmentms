<?php

namespace App\Http\Controllers;

use App\IndustryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndustryCategoryController extends Controller
{
     public function __construct() {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.industry'));
        return view('industry_category', ['pageAuth' => $pageAuth]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.industry'));
        request()->validate([
            'name' => 'required',             
            'code' => 'required', 
        ]);
        if($pageAuth['is_create']){
        $industryCategory = new IndustryCategory();
        $industryCategory->name= \request('name');
        $industryCategory->code= \request('code');
       $msg =  $industryCategory->save();

       if ($msg) {
        return array('id' => 1, 'message' => 'true');
    } else {
        return array('id' => 0, 'message' => 'false');
    }
        }else{
         abort(401);
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
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
           request()->validate([
                'name' => 'required', 
                'code' => 'required',          
            ]);
        if($pageAuth['is_update']){
        $industryCategory = IndustryCategory::findOrFail($id);;
        $industryCategory->name= \request('name');
        $industryCategory->code= \request('code');
       $msg =  $industryCategory->save();

       if ($msg) {
        return array('id' => 1, 'message' => 'true');
    } else {
        return array('id' => 0, 'message' => 'false');
    }
        }else{
         abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IndustryCategory  $industryCategory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
           $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.industry'));
         if($pageAuth['is_read']){
       return IndustryCategory::get();
   }else{
         abort(401);
        }
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
    public function destroy($id)
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.industry'));
        if($pageAuth['is_delete']){
        $industryCategory = IndustryCategory::findOrFail($id);;
        //$attachment->name= \request('name');
       $msg =  $industryCategory->delete();

       if ($msg) {
        return array('id' => 1, 'message' => 'true');
    } else {
        return array('id' => 0, 'message' => 'false');
    }
        }else{
         abort(401);
        }
    }


      public function find($id)
    {

        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.industry'));
         if($pageAuth['is_read']){
       return IndustryCategory::findOrFail($id);
   }else{
         abort(401);
        }
    }



}
