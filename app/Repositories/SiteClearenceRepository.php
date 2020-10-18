<?php

namespace App\Repositories;

use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use Carbon\Carbon;
use App\PaymentType;
use App\Transaction;
use App\SiteClearance;
use App\CommitteeRemark;
use App\SiteClearenceSession;
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
class SiteClearenceRepository
{
    /**
     * Get File with has a site clearence in it
     * from date
     * To date
     * Instance => All , New , Extensions
     */
    public function getSiteClearenceReport($from, $to, $instance)
    {
        $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
        $query =
            Client::join('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->join('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->leftJoin('transactions', 'site_clearence_sessions.id', 'transactions.type_id')
            ->join('transaction_items', 'transactions.id', 'transaction_items.transaction_id')
            ->select(
                'site_clearances.submit_date',
                'site_clearence_sessions.code',
                'clients.name_title',
                'clients.first_name',
                'clients.last_name',
                'clients.address',
                'industry_categories.name as category_name',
                'clients.industry_address',
                'transaction_items.amount',
                'transactions.invoice_no',
                'transactions.billed_at',
                'site_clearence_sessions.issue_date'
            )
            ->where('transactions.type', Transaction::TRANS_SITE_CLEARANCE)
            ->where('transaction_items.payment_type_id', $inspectionTypes->id);


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
