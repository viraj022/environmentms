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
    public function getApplicationCount($from, $to, $type)
    {
        return TransactionItem::with('transactionItems')
            ->where('type', Transaction::APPLICATION_FEE)
            ->select()
            ->get();
    }
}
