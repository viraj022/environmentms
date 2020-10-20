<?php

namespace App\Repositories;

use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use App\EPLNew;
use App\EPLRenew;
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
    public function getEPLReport($from, $to, $instance)
    {
        $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
        $query = EPLNew::with('epl_renews')
            ->join('clients', 'view_e_p_l_s_new.client_id', 'clients.id')
            ->leftJoin('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->leftJoin('transactions', 'view_e_p_l_s_new.id', 'transactions.type_id')
            ->join('transaction_items', 'transactions.id', 'transaction_items.transaction_id')
            ->select(
                'view_e_p_l_s_new.submitted_date',
                'view_e_p_l_s_new.code',
                'clients.name_title',
                'clients.first_name',
                'clients.last_name',
                'clients.address',
                'industry_categories.name as category_name',
                'clients.industry_address',
                'transaction_items.amount',
                'transactions.invoice_no',
                'transactions.billed_at',
                'site_clearence_sessions.issue_date',
                'site_clearence_sessions.code as site_clearence_code',

            );
        dd($query->first()->toArray());

        // Client::join('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
        // ->leftJoin('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
        // ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
        // ->leftJoin('transactions', 'e_p_l_s.id', 'transactions.type_id')
        // ->join('transaction_items', 'transactions.id', 'transaction_items.transaction_id')
        // ->select(
        //     'e_p_l_s.submitted_date',
        //     'e_p_l_s.code',
        //     'clients.name_title',
        //     'clients.first_name',
        //     'clients.last_name',
        //     'clients.address',
        //     'industry_categories.name as category_name',
        //     'clients.industry_address',
        //     'transaction_items.amount',
        //     'transactions.invoice_no',
        //     'transactions.billed_at',
        //     'site_clearence_sessions.issue_date',
        //     'site_clearence_sessions.code as site_clearence_code'
        //     ''
        // )
        // ->where('transactions.type', Transaction::TRANS_TYPE_EPL)
        // ->where('transaction_items.payment_type_id', $inspectionTypes->id)
        // ->orderBy('e_p_l_s.submitted_date', 'DESC');


        switch ($instance) {
            case  'All':
                return $query->get();
            case 'New':
                return $query->where('site_clearances.count', 1)->get();
            case 'extend':
                return $query->where('site_clearances.count', '>', 1)->get();
            default:
                abort('404', 'Report Instance Not Defined - Ceytech internal error log');
        }
    }
}
