<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Payment;
use App\PaymentType;
use App\Transaction;
use App\Rules\contactNo;
use App\TransactionItem;
use App\Rules\nationalID;
use App\ApplicationCliten;
use App\Transactioncounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EPLPaymentController extends Controller
{
    public

    const REG_FEE = 'EPL Application Fee';

    public function addRegistrationPayment()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'name' => 'required|string',
                'nic' => ['sometimes', 'nullable', 'unique:users', new nationalID],
                'address' => 'nullable|max:255',
                'contact_no' => ['nullable', new contactNo],
            ]);
            return \DB::transaction(function () {
                $client = new ApplicationCliten();
                $client->name = request('name');
                $client->nic = request('nic');
                $client->address = request('address');
                $client->contact_no = request('contact_no');
                $msg = $client->save();
                $transaction = new Transaction();
                $transaction->status = 0;
                $transaction->type = Transaction::APPLICATION_FEE;
                $transaction->type_id = $client->id;
                $msg = $msg &&  $transaction->save();
                if ($msg) {
                    $data =  request('items');
                    foreach ($data as $item) {
                        $payment = Payment::find($item['id']);
                        if ($payment) {
                            $transactionItem = new TransactionItem();
                            $transactionItem->transaction_id = $transaction->id;
                            $transactionItem->payment_type_id = $payment->payment_type_id;
                            $transactionItem->payment_id = $payment->id;
                            $transactionItem->transaction_type = Transaction::APPLICATION_FEE;
                            $transactionItem->client_id = $client->id;
                            $transactionItem->amount = $payment->amount;
                            $transactionItem->qty = $item['qty'];
                            $msg = $msg && $transactionItem->save();
                        } else {
                            abort(404);
                        }
                    }
                    if ($msg) {
                        return array('id' => 1, 'message' => 'true', 'code' => $transaction->id);
                    } else {
                        abort(500);
                    }
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            });
        } else {
            abort(401);
        }
    }

    public function deleteApplicationPayment($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            $transaction = Transaction::where('type', Transaction::APPLICATION_FEE)
                ->where('id', $id)->first();
            if ($transaction) {
                if ($transaction->delete()) {
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function getPendingApplicationList()
    {
        // return Transaction::with('transactionItems')->get();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return  $transaction = Transaction::with('transactionItems')
            ->with('applicationClient')
            ->where('status', '<', 2)
            ->where('type', Transaction::APPLICATION_FEE)
            ->get();
    }

    public function markApplicationPayment($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $transaction = Transactioncounter::findOrFail($id);
        $transaction->payment_status = 1;
        $msg = $transaction->save();
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function processApplication($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $transaction = Transaction::where('type', Transaction::APPLICATION_FEE)
                ->where('id', $id)->first();
            // dd($id);
            if ($transaction) {
                if ($transaction->status == 1) {
                    $transaction->status = 2;
                    if ($transaction->save()) {
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                } else {
                    return response(array('id' => 0, 'message' => 'payment not yet completed or payment already processed or bill has been cancelled'), 403);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function getApplicationList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $pt = PaymentType::getpaymentByTypeName(PaymentType::APPLICATIONFEE);
        return Payment::where('payment_type_id', $pt->id)->get();
    }

    public function makeInspectionPayment($eplId)
    {
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $epl = EPL::find($eplId);
            if ($epl) {
                $data = request('payments');
                foreach ($data  as $payment) {
                    switch($payment)
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function getInspectionPaymentList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $pt = PaymentType::getpaymentByTypeName(PaymentType::INSPECTIONFEE);
        return Payment::with('paymentRanges')->where('payment_type_id', $pt->id)->get();
    }

    public function payInspectionFee()
    {
    }
}
