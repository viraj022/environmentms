<?php

namespace App\Http\Controllers;

use App\Pradesheeyasaba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PradesheeyasabaController extends Controller
{
<<<<<<< HEAD
=======

>>>>>>> remotes/origin/relese/general-settings
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
<<<<<<< HEAD
        $user = Auth::user();           
=======
        $user = Auth::user();
>>>>>>> remotes/origin/relese/general-settings
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
<<<<<<< HEAD
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
           request()->validate([
                'name' => 'required|unique:pradesheeyasabas,name',
                'code' => 'required|unique:pradesheeyasabas,code',               

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
=======
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
        request()->validate([
            'name' => 'required|unique:pradesheeyasabas,name',
            'code' => 'required|unique:pradesheeyasabas,code',
            'zone_id' => 'required|numeric',
        ]);
        if ($pageAuth['is_create']) {
            $pradesheyasaba = new Pradesheeyasaba();
            $pradesheyasaba->name = \request('name');
            $pradesheyasaba->code = \request('code');
            $pradesheyasaba->zone_id = \request('zone_id');
            $msg = $pradesheyasaba->save();

            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
>>>>>>> remotes/origin/relese/general-settings
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
<<<<<<< HEAD
    $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
//           request()->validate([
//                'name' => 'required|unique:pradesheeyasabas,name',
//                'code' => 'required|unique:pradesheeyasabas,code',           
//            ]);
        
 
        
        
        
        if($pageAuth['is_update']){
        $pradesheyasaba = Pradesheeyasaba::findOrFail($id);
         if ($pradesheyasaba->name != \request('name')) {
=======
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
        //           request()->validate([
        //                'name' => 'required|unique:pradesheeyasabas,name',
        //                'code' => 'required|unique:pradesheeyasabas,code',           
        //            ]);





        if ($pageAuth['is_update']) {
            $pradesheyasaba = Pradesheeyasaba::findOrFail($id);
            if ($pradesheyasaba->name != \request('name')) {
>>>>>>> remotes/origin/relese/general-settings
                request()->validate([
                    'name' => 'required|unique:pradesheeyasabas,name'
                ]);
                $pradesheyasaba->name = \request('name');
            }
            if ($pradesheyasaba->code != \request('code')) {
                request()->validate([
                    'code' => 'required|unique:pradesheeyasabas,code'
                ]);
                $pradesheyasaba->code = \request('code');
            }
<<<<<<< HEAD
//            $pradesheyasaba ->name = \request('name');
//        $pradesheyasaba ->code = \request('code');
       $msg =  $pradesheyasaba->save();
=======
            request()->validate([
                'zone_id' => 'required|numeric'
            ]);
            $pradesheyasaba->zone_id = \request('zone_id');
            $msg = $pradesheyasaba->save();
>>>>>>> remotes/origin/relese/general-settings

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
<<<<<<< HEAD
       $user = Auth::user();           
=======
        $user = Auth::user();
>>>>>>> remotes/origin/relese/general-settings
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
         if($pageAuth['is_read']){
       return Pradesheeyasaba::get();
   }else{
         abort(401);
        }
    }
    public function getLocalAuthorityByZone($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
        if ($pageAuth['is_read']) {
            return Pradesheeyasaba::where('zone_id','=',$id)->get();
        } else {
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
<<<<<<< HEAD
        $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
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
=======
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
        if ($pageAuth['is_delete']) {
            $pradesheyasaba = Pradesheeyasaba::findOrFail($id);;
            //$attachment->name= \request('name');
            $msg = $pradesheyasaba->delete();

            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
>>>>>>> remotes/origin/relese/general-settings
        }
    }

    public function find($id)
    {
<<<<<<< HEAD
        $user = Auth::user();           
=======
        $user = Auth::user();
>>>>>>> remotes/origin/relese/general-settings
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));
         if($pageAuth['is_read']){
       return Pradesheeyasaba::findOrFail($id);
   }else{
         abort(401);
        }
    }
<<<<<<< HEAD
    
        public function isNameUnique($name) {
=======

    public function isNameUnique($name)
    {
>>>>>>> remotes/origin/relese/general-settings
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));

        if ($pageAuth['is_create']) {
            $raw = Pradesheeyasaba::where('name', '=', $name)->first();
            if ($raw === null) {
                return array('id' => 1, 'message' => 'unique');
            } else {
                return array('id' => 1, 'message' => 'notunique');
            }
        }
    }
<<<<<<< HEAD
    
    
            public function isCodeUnique($code) {
=======

    public function isCodeUnique($code)
    {
>>>>>>> remotes/origin/relese/general-settings
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.pradesheyasaba'));

        if ($pageAuth['is_create']) {
            $raw = Pradesheeyasaba::where('code', '=', $code)->first();
            if ($raw === null) {
                return array('id' => 1, 'message' => 'unique');
            } else {
                return array('id' => 1, 'message' => 'notunique');
            }
        }
    }
}
