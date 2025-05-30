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
use App\Http\Controllers\FieUploadController;
use App\InspectionSession;

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
        $query = Client::join('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->join('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->leftJoin('transactions', 'site_clearence_sessions.id', 'transactions.type_id')
            ->leftJoin('transaction_items', 'transactions.id', 'transaction_items.transaction_id')
            ->select(
                'site_clearances.submit_date',
                'site_clearances.count',
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
                'site_clearence_sessions.issue_date',
                'site_clearence_sessions.created_at',
                'clients.id as client_id'
            )
            ->whereNotNull('site_clearence_sessions.issue_date')
            ->whereBetween('site_clearence_sessions.issue_date', [$from, $to])
            ->orWhere('site_clearence_sessions.issue_date', '=', null)
            ->where('transactions.type', Transaction::TRANS_SITE_CLEARANCE)
            ->where('transaction_items.payment_type_id', $inspectionTypes->id)
            ->orderBy('site_clearence_sessions.created_at', 'DESC');

        switch ($instance) {
            case 'all':
                return $query->get();
            case 'new':
                return $query->where('site_clearances.count', 1)->get();
            case 'extend':
                return $query->where('site_clearances.count', '>', 1)->get();
            default:
                abort('404', 'Report Instance Not Defined - Ceytech internal error log');
        }
    }
    public function getSiteClearenceReportBySubmitDate($from, $to, $instance)
    {
        // $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
        $query = Client::join('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->join('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            // ->leftJoin('transactions', 'site_clearence_sessions.id', 'transactions.type_id')
            // ->leftJoin('transaction_items', 'transactions.id', 'transaction_items.transaction_id')
            ->select(
                'site_clearances.submit_date',
                'site_clearances.count',
                'site_clearence_sessions.code',
                'clients.name_title',
                'clients.first_name',
                'clients.last_name',
                'clients.address',
                'industry_categories.name as category_name',
                'clients.industry_address',
                // 'transaction_items.amount',
                // 'transactions.invoice_no',
                // 'transactions.billed_at',
                'site_clearence_sessions.issue_date',
                // 'site_clearence_sessions.created_at',
                'clients.id as client_id',
                'clients.industry_sub_category'
            )
            ->whereNotNull('site_clearances.issue_date')
            ->whereBetween('site_clearances.issue_date', [$from, $to])
            // ->where('transactions.type', Transaction::TRANS_SITE_CLEARANCE)
            // ->where('transaction_items.payment_type_id', $inspectionTypes->id)
            ->orderBy('site_clearence_sessions.created_at', 'DESC');
        switch ($instance) {
            case 'all':
                $query->get();
                break;
            case 'new':
                $query = $query->where('site_clearances.count', 0);
                break;
            case 'extend':
                $query = $query->where('site_clearances.count', '>', 0);
                break;
            default:
                abort('404', 'Report Instance Not Defined - Ceytech internal error log');
        }
        return $query->get();
    }

    public function ReceivedSiteCount($from, $to, $isNew)
    {
        // dd($from, $to, $isNew);
        $query = SiteClearance::whereBetween('submit_date', [$from, $to])
            ->join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.name AS zone_name', 'zones.id AS zone_id', DB::raw('count(site_clearances.id) as total'))
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
        }
        // $query = $query->toSql();
        // dd($query);
        return  $query = $query->get()->keyBy('zone_id');
    }

    public function IssuedSiteCount($from, $to, $isNew)
    {
        // dd($isNew);
        $query = SiteClearance::join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            // ->whereNotNull('site_clearances.issue_date')
            ->whereBetween('site_clearances.issue_date', [$from, $to])
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(site_clearances.id) as total'))
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
                abort(422, "invalid Argument for the if HCE-log");
                break;
        }
        // $query = $query->toSql();
        // dd($query);
        return $query->get()->keyBy('zone_id');
    }

    public function SiteCount($from, $to, $isNew = -1, $issueStatus = 0, $SiteType = 0)
    {
        $query = SiteClearance::join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(site_clearances.id) as total'))
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        switch ($isNew) {
            case 1:
                $query = $query->where('count', 1);
                break;
            case 0:
                $query = $query->where('count', '>', 1);
                break;
            default:
        }

        switch ($issueStatus) {
            case 0: // received
                $query = $query->whereBetween('submit_date', [$from, $to]);
                break;
            case 1: // issued
                $query = $query->where('site_clearances.status', 1)
                    ->whereBetween('site_clearances.issue_date', [$from, $to]);
                break;
            case 2: // rejected
                $query = $query->where('site_clearances.status', -1)
                    ->whereBetween('site_clearances.rejected_date', [$from, $to]);
                break;
            default:
        }
        if ($SiteType !== 0) {
            $query = $query->where('site_clearance_type', $SiteType);
        }
        return $query->get()->keyBy('zone_id');
    }

    public function extendSiteClearance($request, $siteClearence)
    {
        return DB::transaction(function () use ($request, $siteClearence) {
            $site = new SiteClearance();
            $site->site_clearence_session_id = $siteClearence->site_clearence_session_id;
            if ($request->file('file') != null) {
                $fileUrl = 'uploads/' . FieUploadController::getSiteClearanceAPPLICATIONFilePath($site->siteClearenceSession);
                $path = $request->file('file')->store($fileUrl);
            } else {
                return response(array('id' => 1, 'message' => 'Application not found'), 422);
            }
            $site->submit_date = $request->submit_date;
            $site->application_path = $path;
            $site->status = 0;
            $site->count = $this->getLastSiteClearance($site->siteClearenceSession->client_id)->count + 1;
            $file = $site->siteClearenceSession->client;
            $file->file_status = 0;
            $file->need_inspection = Client::STATUS_INSPECTION_NEEDED;
            $file->save();
            $clent = Client::find($request->client_id);
            $clent->cer_type_status = 4;
            $clent->cer_status = 0;
            $clent->save();
            return $site->save();
        });
    }

    public function getLastSiteClearance($client_id)
    {
        $siteClearanceSession = SiteClearenceSession::where('client_id', $client_id)
            ->orderBy('id', 'DESC')
            ->first();
        $rtn = $siteClearance = $siteClearanceSession->siteClearances->last();
        // dd($rtn);
        return $rtn;
    }

    public function getLastSiteClearanceBySiteClearenceSessionId($id)
    {
        $siteClearanceSession = SiteClearenceSession::findOrFail($id);

        $rtn = $siteClearanceSession->siteClearances->last();
        return $rtn;
    }

    public function getSiteReport($from, $to)
    {
        // $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);


        // $query = SiteClearenceSession::with('client.industryCategory', 'siteClearances')
        //     ->join('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
        //     ->where('site_clearances.status', 1)
        //     ->whereNotNull('site_clearances.submit_date')
        //     ->whereBetween('site_clearances.submit_date', [$from, $to]);

        // $query = $query->get()->toArray();
        // return $query;
        $query = SiteClearance::join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->select(
                'clients.id',
                'clients.first_name',
                'clients.last_name',
                'clients.name_title',
                'clients.address',
                'clients.industry_sub_category',
                'clients.industry_address',
                'site_clearances.submit_date',
                'site_clearances.issue_date',
                'site_clearances.count',
                'site_clearence_sessions.code',
                'site_clearence_sessions.site_clearance_type',
                'site_clearence_sessions.issue_date as session_issue_date',
                'industry_categories.name as industry_category',
            )
            ->whereNotNull('site_clearances.submit_date')
            ->whereBetween('site_clearances.submit_date', [$from, $to])
            ->get()->toArray();
        // ->toSql();
        // dd($query);
        return $query;
    }
    public function telicomTowerCount($from, $to)
    {
        $query = SiteClearance::join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(site_clearances.id) as total'))
            ->whereNotNull('site_clearances.submit_date')
            ->whereBetween('site_clearances.submit_date', [$from, $to])
            ->where('clients.industry_category_id', '=', '76')
            ->groupBy('zones.id')
            ->get()->keyBy('zone_id');
        return $query;
    }
    public function siteClearanceDetailsBySubmitDate($from, $to, $isNew)
    {
        $query = SiteClearance::whereBetween('submit_date', [$from, $to])
            ->join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.name AS zone', 'site_clearence_sessions.code AS sc_code', 'clients.industry_name', 'site_clearances.submit_date', 'clients.id AS client_id')
            ->orderBy('zones.name');
        // $query->where('count', 0);
        switch ($isNew) {
            case 1:
                $query->where('count', 0);
                break;
            case 0:
                $query->where('count', '>', 0);
                break;
            default:
                abort(422, "invalid Argument for isNew");
        }
        // $query = $query->toSql();
        // dd($query);
        return  $query = $query->get();
    }
}
