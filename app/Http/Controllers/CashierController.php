<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getDetailsByCode($code)
    {
        $transaction = Transaction::findOrFail($code);
        switch ($transaction->transaction_type) {
            case (Transaction::APPLICATION_FEE):
                return   Transaction::join('application_clitens', 'transactions.transaction_id', 'application_clitens.id')
                    ->join('payments', 'transactions.payment_id', 'payments.id')
                    ->select(
                        'application_clitens.name as client_name',
                        'application_clitens.nic as client_nic',
                        'application_clitens.address as client_address',
                        'application_clitens.contact_no as client_contact_no',
                        'transactions.id as transaction_id',
                        'transactions.amount as amount',
                        'payments.name as paymentName'
                    )
                    ->where('transactions.id', $code)
                    ->first();
            default:
                return array('id' => 0, 'message' => 'false');
        }
    }
}
