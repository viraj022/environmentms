<?php

namespace App\Repositories;

use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use Carbon\Carbon;
use App\PaymentType;
use App\Transaction;

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
class EPLRepository
{
    /**
     * Get File with has a site clearence in it
     * from date
     * To date
     * Instance => All , New , Extensions
     */
    public function getEPLReport($from, $to)
    {
        $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);

        $query =
            Client::whereHas('epls')
            ->with('epls')
            ->with('siteClearenceSessions')
            ->with(['transactions.transactionItems' => function ($query) use ($inspectionTypes) {
                $query->where('payment_type_id', $inspectionTypes->id)->where('transaction_type', Transaction::TRANS_TYPE_EPL);
            }])
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->select(
                'clients.id',
                'clients.name_title',
                'clients.first_name',
                'clients.last_name',
                'clients.address',
                'industry_categories.name as category_name',
                'clients.industry_address',
            );

        return $query->get();
    }
}
