<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Transaction;
use App\LogActivity;
use App\ApplicationCliten;
use App\Client;
use App\TransactionItem;
use App\Rules\nationalID;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use App\PaymentType;
use App\Payment;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getDetailsByCode($id)
    {
        $transaction = Transaction::with('transactionItems.payment')
            ->where('id', $id)
            ->first();
        if (Transaction::APPLICATION_FEE == $transaction->type) {
            $transaction = Transaction::with('transactionItems.payment')->with('applicationClient')
                ->where('id', $id)
                ->first();
        } else {
            $transaction->application_Client = $transaction->client;
            $transaction->application_Client->name = $transaction->client->first_name;
            // dd($transaction->client);
        }


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
            //  LogActivity::addToLog($transaction->invoice_no.'payment Added',$transaction);
            return array('id' => 1, 'message' => 'true');
        } else {
            // LogActivity::addToLog('Fail to Add transaction' . $transaction->invoice_no, $transaction);
            return array('id' => 1, 'message' => 'false');
        }
    }
    public function cancel($id)
    {
        $transaction = Transaction::where('invoice_no', $id)->first();
        $transaction->status = 3;
        $transaction->canceled_at = Carbon::now()->toDateTimeString();
        if ($transaction->save()) {
            //  LogActivity::addToLog($transaction->invoice_no . 'canceled', $transaction);
            return array('id' => 1, 'message' => 'true');
        } else {
            //    LogActivity::addToLog('faiL TO cancel' . $transaction->invoice_no, $transaction);
            return array('id' => 1, 'message' => 'false');
        }
    }

    public function getPendingPaymentList()
    {
        $a =   array();
        return    $transaction = Transaction::whereNull('billed_at')->get();
    }

    public function getPendingPaymentByFileID($id)
    {
        return Transaction::with('transactionItems')->with('client')->where('client_id', $id)->get();
    }


    public function getPaymentTypes()
    {
        $paymentType = PaymentType::get();
        return $paymentType;
    }

    public function getPayments()
    {
        $payment = Payment::get();
        return $payment;
    }
}
