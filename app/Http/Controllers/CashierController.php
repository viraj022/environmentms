<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Transaction;
use App\ApplicationCliten;
use App\Client;
use App\TransactionItem;
use App\Rules\nationalID;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getDetailsByCode($id)
    {
        $transaction = Transaction::with('applicationClient')
            ->with('transactionItems.payment')
            ->where('id', $id)
            ->first();
        if ($transaction) {
            return $transaction;
        } else {
            return array("id" => 0, "message" => 'Not Found');
        }
    }
    public function pay($id)
    {
        request()->validate([
            'cashier_name' => 'required|string',
            'invoice_no' => ['required', 'string'],
        ]);
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 1;
        $transaction->cashier_name = request('cashier_name');
        $transaction->invoice_no = request('invoice_no');
        $transaction->billed_at = Carbon::now()->toDateTimeString();
        if ($transaction->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 1, 'message' => 'false');
        }
    }
    public function cancel($id)
    {
        $transaction = Transaction::where('invoice_no', $id)->first();
        $transaction->status = 3;
        $transaction->canceled_at = Carbon::now()->toDateTimeString();
        if ($transaction->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 1, 'message' => 'false');
        }
    }

    public function getPendingPaymentList(){
        $a =   Array(); 
        $transaction = Transaction::whereNull('billed_at')->get();
        foreach ($transaction as &$value) {
        
         if($value->type == 'application_fee'){
           
             $value['name'] = ApplicationCliten::findOrFail($value->type_id)->name;
         }else{
             $value['name'] =  Client::findOrFail($value->type_id)->name;
        }       
      
        array_push($a,$value);
        }
     return $a;  
    
}

    public function getPendingPaymentByFileID($id){
 
   return Transaction::with('transactionItems')->whereHas('transactionItems', function ( $query) use($id) {
    $query->where('client_id', '=', $id)->where('transaction_type', '!=', 'application_fee');
        })->get();
    
}
}

