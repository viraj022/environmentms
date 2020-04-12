<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public const INSPECTION = 'inspection';
    public const LICENCE_FEE = 'licence_fee';
    public const APPLICATION_FEE = 'application_fee';

    public function getPaymentDetails()
    {
        $transactionSum = Transaction::where('type', '=', $this->type)
            ->where('transaction_id', '=', $this->transaction_id)->sum('amount');

        $transactionCounterSum = Transactioncounter::where('payment_id', '=', $this->payment_id)
            ->where('type', '=', $this->type)
            ->where('transaction_id', '=', $this->transaction_id)
            ->where('payment_status', '=', 1)
            ->sum('amount');
        return array('amount' => $transactionSum, 'payed' => $transactionCounterSum);
    }
}
