<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EPLPaymentController extends Controller
{
    public const REG_FEE = 'EPL Application Fee';

    public function addRegistrationPayment($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $payment = Payment::getPaymentByName(EPLPaymentController::REG_FEE);
            if ($payment) {
                request()->validate([
                    'amount' => 'required|numeric',
                ]);
                $transaction  = new  Transaction();
                $transaction->payment_type_id = $payment->payment_type_id;
                $transaction->payment_id = $payment->id;
                $transaction->transaction_type = Transaction::TRANS_TYPE_EPL;
                $transaction->transaction_id = $id;
                $transaction->status = 0;
                $transaction->amount = request('amount');
                $msg = $transaction->save();
                if ($msg) {
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 1, 'message' => 'false');
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function checkRegPament($id)
    {
    }
}
