<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;

class TransactionController extends Controller
{
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
    public static function create($request)
    {
        $transaction = new Transaction();
        $transaction->payment_type_id = $request['payment_type_id'];
        $transaction->payment_id = $request['payment_id'];
        $transaction->transaction_type = $request['transaction_type'];
        $transaction->transaction_id = $request['transaction_id'];
        $transaction->amount = $request['amount'];
        $transaction->transaction_id = $request['transaction_id'];
        $transaction->status = $request['status'];
        $transaction->type = $request['type'];
        $msg = $transaction->save();

        if ($msg) {
            LogActivity::addToLog('Created : TransactionController',$transaction);            
            return array('id' => 1, 'message' => 'true');
        } else {
            LogActivity::addToLog('Fail to Create : TransactionController',$transaction);
            return array('id' => 0, 'message' => 'false');
        }

        
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

    public function find($id)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
