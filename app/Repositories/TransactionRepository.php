<?php

namespace App\Repositories;

use App\AssistantDirector;
use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use Carbon\Carbon;
use App\PaymentType;
use App\Transaction;
use App\TransactionItem;
use Illuminate\Support\Facades\DB;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SurveyRepository
 *
 * @author hansana
 */
class TransactionRepository
{
    /**
     * Get File with has a site clearence in it
     * from date
     * To date
     * Instance => All , New , Extensions
     */
    public function getApplicationCount($from, $to)
    {
        $data = TransactionItem::join('transactions', 'transaction_items.transaction_id', 'transactions.id')
            ->join('payments', 'transaction_items.payment_id', 'payments.id')
            ->where('transactions.type', Transaction::APPLICATION_FEE)
            ->whereBetween('billed_at', [$from, $to])
            ->select(DB::raw('sum(qty) as qty'), 'payments.name')
            ->groupBy('payment_id')
            ->get();
        // dd($data->toArray());
        return $data;
    }
}
