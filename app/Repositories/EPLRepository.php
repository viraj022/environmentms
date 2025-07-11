<?php

namespace App\Repositories;

use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use Carbon\Carbon;
use App\PaymentType;
use App\SiteClearance;
use App\SiteClearenceSession;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use App\TransactionItem;

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

        // Optimized query with better eager loading and reduced N+1 queries
        $query = EPL::select([
            'e_p_l_s.id',
            'e_p_l_s.client_id',
            'e_p_l_s.code',
            'e_p_l_s.certificate_no',
            'e_p_l_s.issue_date',
            'e_p_l_s.expire_date',
            'e_p_l_s.submitted_date',
            'e_p_l_s.created_at',
            'e_p_l_s.count'
        ])
            ->with([
                'client:id,first_name,last_name,name_title,address,industry_address,industry_sub_category,file_no,industry_category_id',
                'client.industryCategory:id,name',
                'client.siteClearenceSessions:id,client_id,code',
                'client.certificates:id,client_id,refference_no'
            ])
            ->whereBetween('issue_date', [$from, $to])
            ->orderBy('e_p_l_s.issue_date')
            ->groupBy('e_p_l_s.client_id')
            ->get();

        // Load inspection fee data separately to avoid complex nested queries
        $clientIds = $query->pluck('client_id')->unique();
        $inspectionFees = TransactionItem::select([
            'transaction_items.amount',
            'transaction_items.transaction_id',
            'transactions.client_id',
            'transactions.billed_at'
        ])
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transaction_items.payment_type_id', $inspectionTypes->id)
            ->where('transaction_items.transaction_type', Transaction::TRANS_TYPE_EPL)
            ->whereIn('transactions.client_id', $clientIds)
            ->get()
            ->groupBy('client_id');

        // Attach inspection fee data to the results
        $query->each(function ($epl) use ($inspectionFees) {
            $clientId = $epl->client_id;
            if (isset($inspectionFees[$clientId])) {
                $epl->inspection_fee_data = $inspectionFees[$clientId]->first();
            } else {
                $epl->inspection_fee_data = null;
            }
        });

        return $query;
    }

    public function getEPLApplicationLog($from, $to)
    {
        $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
        $query = EPL::with(['client.industryCategory', 'client.siteClearenceSessions', 'client.certificates'])
            ->with(['client.transactions.transactionItems' => function ($query) use ($inspectionTypes) {
                $query->where('payment_type_id', $inspectionTypes->id)->where('transaction_type', Transaction::TRANS_TYPE_EPL);
            }])
            ->whereBetween('submitted_date', [$from, $to])
            ->orderBy('e_p_l_s.issue_date')
            ->groupBy('e_p_l_s.client_id')
            ->get();
        return $query;
    }

    public function ReceivedPLCount($from, $to, $isNew)
    {
        $query = EPL::whereBetween('submitted_date', [$from, $to])
            ->join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.name as zone_name', 'zones.id as zone_id', DB::raw('count(e_p_l_s.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                $query->where('count', 0);
                break;
            case 0:
                $query->where('count', '>', 0);
                break;
            default:
                abort(422, "invalid Argument for the if HCE-log");
                break;
        }
        $query = $query->get()->keyBy('zone_id');
        return $query;
    }

    public function IssuedPLCount($from, $to, $isNew)
    {
        $query = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->whereBetween('e_p_l_s.issue_date', [$from, $to])
            ->where('e_p_l_s.status', 1)
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(e_p_l_s.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                $query->where('count', 0);
                break;
            case 0:
                $query->where('count', '>', 0);
                break;
            default:
                abort(422, "invalid Argument for the if HCE-log");
                break;
        }
        $query = $query->get()->keyBy('zone_id');
        return $query;
    }

    public function EPlPLCount($from, $to, $isNew, $issueStatus = 0)
    {
        $query = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(e_p_l_s.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                $query = $query->where('count', 0);
                break;
            case 0:
                $query = $query->where('count', '>', 0);
                break;
            default:
        }
        switch ($issueStatus) {
            case 0: // received
                $query = $query->whereBetween('e_p_l_s.submitted_date', [$from, $to]);
                break;
            case 1: // issued
                $query = $query->where('e_p_l_s.status', 1)
                    ->whereBetween('e_p_l_s.issue_date', [$from, $to]);
                break;
            case 2: // rejected
                $query = $query->where('e_p_l_s.status', -1)
                    ->whereBetween('e_p_l_s.rejected_date', [$from, $to]);
                break;
            default:
                abort(422, "invalid Argument for the isIssueStatus HCE-log");
        }

        return $query->get()->keyBy('zone_id');
    }

    /**
     *
     */
    public function TowerEPlPLCount($from, $to, $isNew, $issueStatus = 0)
    {
        $query = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            // ->join('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            //76 = telicommunication tower
            ->where('clients.industry_category_id', 76)
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(e_p_l_s.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 0:
                $query = $query->where('count', '>', 0);
                break;
            case 1:
                $query = $query->where('count', 0);
                break;
            default:
        }
        switch ($issueStatus) {
            case 0: // received
                $query = $query->whereBetween('e_p_l_s.submitted_date', [$from, $to]);
                break;
            case 1: // issued
                $query = $query->where('e_p_l_s.status', 1)
                    ->whereBetween('e_p_l_s.issue_date', [$from, $to]);
                break;
            case 2: // rejected
                $query = $query->where('e_p_l_s.status', -1)
                    ->whereBetween('e_p_l_s.rejected_date', [$from, $to]);
                break;
            default:
                abort(422, "invalid Argument for the isIssueStatus HCE-log");
        }

        // dd($query->toSql());
        return $query->get()->keyBy('zone_id');
    }
    public function eplBySubmitDate($from, $to, $isNew)
    {
        $query = EPL::whereBetween('submitted_date', [$from, $to])
            ->join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.name AS zone', 'e_p_l_s.code AS epl_code', 'clients.industry_name', 'e_p_l_s.submitted_date', 'clients.id AS client_id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                return $query->where('count', 0)->get();
            case 0:
                return $query->where('count', '>', 0)->get();
            default:
                abort(422, "invalid Argument for isNew");
        }
    }
}
