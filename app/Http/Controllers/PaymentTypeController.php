<?php

namespace App\Http\Controllers;

use App\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        return view('payment_type', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $user = Auth::user();           
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
           request()->validate([
                'name' => 'required|unique:payment_types,name'          
            ]);

        if($pageAuth['is_create']){
        $payment_type = new PaymentType();
        $payment_type->name= \request('name');
       $msg =  $payment_type->save();

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
    $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
    request()->validate([
                  'name' => 'required|unique:payment_types,name'  
    ]);
    if ($pageAuth['is_update']) {
        $payment_type =  PaymentType::findOrFail($id);
        $payment_type->name= \request('name');
         $msg =  $payment_type->save();

     if ($msg) {
        return array('id' => 1, 'message' => 'true');
    } else {
        return array('id' => 0, 'message' => 'false');
    }
} else {
    abort(401);
}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
           $user = Auth::user();
    $pageAuth = $user->authentication(config('auth.privileges.industry'));
       dd($pageAuth);
    if ($pageAuth['is_read']) {
        return PaymentType::get();
    } else {
        abort(401);
    }
    }


    //find a paymentType
public function find($id) {

    $user = Auth::user();
    $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
    if ($pageAuth['is_read']) {
        return PaymentType::findOrFail($id);
    } else {
        abort(401);
    }
}
    //end find a paymentType

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
           $user = Auth::user();
    $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
    if ($pageAuth['is_delete']) {
       $payment_type = PaymentType::findOrFail($id);    
       $msg = $payment_type->delete();
       if ($msg) {
        return array('id' => 1, 'message' => 'true');
    } else {
        return array('id' => 0, 'message' => 'false');
    }
} else {
    abort(401);
}
    }


}
