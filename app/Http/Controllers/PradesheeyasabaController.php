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
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
           request()->validate([
                'name' => 'required',
                'code' => 'required',               

            ]);
        if($pageAuth['is_create']){
        $pradesheyasaba = new Pradesheeyasaba();
        $pradesheyasaba->name= \request('name');
        $pradesheyasaba->code= \request('code');
       $msg =  $pradesheyasaba->save();

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
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
           request()->validate([
                'name' => 'required', 
                'code' => 'required',          
            ]);
        if($pageAuth['is_update']){
        $pradesheyasaba = Pradesheeyasaba::findOrFail($id);
        $pradesheyasaba ->name = \request('name');
        $pradesheyasaba ->code = \request('code');
       $msg =  $pradesheyasaba->save();

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
     * @param  \App\Pradesheeyasaba  $pradesheeyasaba
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
         if($pageAuth['is_read']){
       return Pradesheeyasaba::get();
   }else{
         abort(401);
        }
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
    public function destroy($id)
    {
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
           request()->validate([
                'name' => 'required', 
            ]);
        if($pageAuth['is_delete']){
        $pradesheyasaba = Pradesheeyasaba::findOrFail($id);;
        //$attachment->name= \request('name');
       $msg =  $pradesheyasaba->delete();

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
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
         if($pageAuth['is_read']){
       return Pradesheeyasaba::findOrFail($id);
   }else{
         abort(401);
        }
    }
}
