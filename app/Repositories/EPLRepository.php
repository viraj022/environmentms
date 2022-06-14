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
        $query = EPL::with(['client.industryCategory', 'client.siteClearenceSessions', 'client.certificates'])
            ->with(['client.transactions.transactionItems' => function ($query) use ($inspectionTypes) {
                $query->where('payment_type_id', $inspectionTypes->id)->where('transaction_type', Transaction::TRANS_TYPE_EPL);
            }])
            ->whereBetween('issue_date', [$from, $to])
            ->orderBy('e_p_l_s.issue_date')
            ->groupBy('e_p_l_s.client_id')
            ->get();
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
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->where('assistant_directors.active_status', 1)
            ->select('assistant_directors.id as ass_id', 'users.first_name', 'users.last_name', DB::raw('count(e_p_l_s.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                return $query->where('count', 0)->get();
            case 0:
                return $query->where('count', '>', 0)->get();
            default:
                abort(422, "invalid Argument for the if HCE-log");
        }
    }

    public function IssuedPLCount($from, $to, $isNew)
    {
        $query = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->where('assistant_directors.active_status', 1)
            ->whereBetween('e_p_l_s.issue_date', [$from, $to])
            ->where('e_p_l_s.status', 1)
            ->select('assistant_directors.id as ass_id', 'users.first_name', 'users.last_name', DB::raw('count(e_p_l_s.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                return $query->where('count', 0)->get();
            case 0:
                return $query->where('count', '>', 0)->get();
            default:
                abort(422, "invalid Argument for the if HCE-log");
        }
    }

    public function EPlPLCount($from, $to, $isNew, $issueStatus = 0)
    {
        $query = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->where('assistant_directors.active_status', 1)
            ->select('assistant_directors.id as ass_id', 'users.first_name', 'users.last_name', DB::raw('count(e_p_l_s.id) as total'))
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

        return $query->get();
    }

    /**
     *
     */
    public function TowerEPlPLCount($from, $to, $isNew, $issueStatus = 0)
    {
        $query = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->join('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->where('assistant_directors.active_status', 1)
            ->where('clients.industry_category_id', 76)
            ->select('assistant_directors.id as ass_id', 'users.first_name', 'users.last_name', DB::raw('count(e_p_l_s.id) as total'))
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

        // dd($query->toSql());
        return $query->get();
    }
}
