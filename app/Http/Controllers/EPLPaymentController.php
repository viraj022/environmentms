<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Transaction;
use App\Rules\contactNo;
use App\Rules\nationalID;
use App\ApplicationCliten;
use App\Transactioncounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EPLPaymentController extends Controller
{
    public const REG_FEE = 'EPL Application Fee';

    public function addRegistrationPayment()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'name' => 'required|string',
                'nic' => ['sometimes', 'nullable', 'unique:users', new nationalID],
                'address' => 'nullable|max:255',
                'contact_no' =>  ['nullable', new contactNo],
            ]);
            return    \DB::transaction(function () {
                $client =  new  ApplicationCliten();
                $client->name = request('name');
                $client->nic = request('nic');
                $client->address = request('address');
                $client->contact_no = request('contact_no');
                $a = $client->save();
                if ($a) {
                    $payment = Payment::getPaymentByName(EPLPaymentController::REG_FEE);
                    if ($payment) {
                        request()->validate([
                            'amount' => 'required|numeric',
                        ]);
                        $transaction  = new  Transaction();
                        $transaction->payment_type_id = $payment->payment_type_id;
                        $transaction->payment_id = $payment->id;
                        $transaction->transaction_type = Transaction::APPLICATION_FEE;
                        $transaction->transaction_id = $client->id;
                        $transaction->status = 0;
                        $transaction->amount = request('amount');
                        $transaction->type  = "";
                        $msg = $transaction->save();
                        if ($msg) {
                            return array('id' => 1, 'message' => 'true', 'code' => $transaction->id);
                        } else {
                            return array('id' => 0, 'message' => 'false');
                        }
                    } else {
                        abort(404);
                    }
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            });
        } else {
            abort(401);
        }
    }

    public function getPendingApplicationList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return Transactioncounter::join('transactions', 'transactioncounters.transaction_id', 'transactions.id')
            ->join('application_clitens', 'transactions.transaction_id', 'application_clitens.id')
            ->where('payment_status', 0)
            ->where('transaction_type', Transaction::APPLICATION_FEE)
            ->select('application_clitens.*', 'transactioncounters.id as counter_id')
            ->get();
    }

    public function markApplicationPayment($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $transaction =  Transactioncounter::findOrFail($id);
        $transaction->payment_status = 1;
        $msg = $transaction->save();
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }
}
