<?php

namespace App\Repositories;

use App\Client;
use App\FileView;
use App\IndustryCategory;
use Carbon\Carbon;
use App\SiteClearance;
use App\InspectionSession;
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
class ClientRepository
{
    public function rejectionWorkingFileType($client)
    {
        $data = $client->getActiveWorkingFileType();
        if (!empty($data)) {
            if ($data['type'] == 'EPL') {
                $model = $data['model'];
                $model->status = -1;
                $model->rejected_date = Carbon::now();
                // dd($model);
                $model->save();
            } else if ($data['type'] == 'SITE') {
                $model = $data['model'];
                $model->status = -1;
                $model->rejected_date = Carbon::now();
                $model->save();
                // dd($model);
                $site = SiteClearenceSession::findOrFail($model->site_clearence_session_id);
                $site->status = -1;
                $site->save();
            }
        } else {
            abort(501, "No file type found - hcw log");
        }
    }

    public function all()
    {
        return Client::Join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->join('business_scales', 'clients.business_scale_id', 'business_scales.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->leftJoin('environment_officers', 'clients.environment_officer_id', 'environment_officers.id')
            ->leftJoin('users as eo_users', 'environment_officers.user_id', 'eo_users.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users as as_users', 'assistant_directors.user_id', 'as_users.id')
            ->leftJoin('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
            ->leftJoin('site_clearence_sessions', 'clients.id', 'site_clearence_sessions.client_id')
            ->leftJoin('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
            ->where('environment_officers.active_status', 1)
            ->where('assistant_directors.active_status', 1)
            /**
             * filtering soft deletes
             */
            // ->whereNotNull('site_clearence_sessions.deleted_at')
            // ->whereNotNull('site_clearances.deleted_at')
            // ->whereNotNull('e_p_l_s.deleted_at')
            ->select(
                /**
                 * common set set
                 */
                'clients.*',
                'business_scales.name as business_scale_name',
                'pradesheeyasabas.name as pradesheeyasaba_name',
                'industry_categories.name as category_name',
                'zones.name as zone_name',
                /**
                 * epl set
                 */
                'e_p_l_s.id as epl_id',
                'e_p_l_s.code as epl_code',
                'e_p_l_s.issue_date as epl_issue_date',
                'e_p_l_s.expire_date as epl_expire_date',
                'e_p_l_s.submitted_date as epl_submitted_date',
                'e_p_l_s.certificate_no as epl_certificate_no',
                'e_p_l_s.count as epl_count',
                'e_p_l_s.status as epl_status',
                'e_p_l_s.rejected_date as epl_rejected_date',
                'e_p_l_s.deleted_at as epl_deleted_at',
                /**
                 * site clearance set
                 */
                'site_clearence_sessions.code as site_code',
                'site_clearence_sessions.site_clearance_type as site_site_clearance_type',
                'site_clearence_sessions.processing_status as site_processing_status',
                'site_clearence_sessions.licence_no as site_licence_no',
                'site_clearence_sessions.deleted_at as site_session_deleted_at',
                'site_clearances.submit_date as site_submit_date',
                'site_clearances.issue_date as site_issue_date',
                'site_clearances.expire_date as site_expire_date',
                'site_clearances.rejected_date as site_rejected_date',
                'site_clearances.status as site_status',
                'site_clearances.count as site_count',
                'site_clearances.deleted_at as site_deleted_at',
                /**
                 * assistance director
                 */
                'as_users.first_name as assistance_first_name',
                'as_users.last_name as assistance_last_name',
                /**
                 * eo
                 */
                'eo_users.first_name as officer_first_name',
                'eo_users.last_name as officer_last_name'


            )
            ->get();
    }

    public function allPlain($from, $to)
    {

        // echo $client;
        $file = FileView::orWhereBetween('epl_issue_date', [$from, $to])
            ->orWhereBetween('epl_expire_date', [$from, $to])
            ->orWhereBetween('epl_submitted_date', [$from, $to])
            ->orWhereBetween('epl_rejected_date', [$from, $to])
            ->orWhereBetween('site_submit_date', [$from, $to])
            ->orWhereBetween('site_issue_date', [$from, $to])
            ->orWhereBetween('site_expire_date', [$from, $to])
            ->orWhereBetween('site_rejected_date', [$from, $to]);
        // dd(FileView::all());
        // echo $file->toSql();
        return $file->get();
    }
    public function allPlainWithoutDates()
    {
        $file = FileView::all();
    }

    public function getRowFiles()
    {
        $query = FileView::select(
            'name_title as title',
            'first_name as First Name',
            'last_name as Last Name',
            'address as Address',
            'contact_no as Contact No',
            'email as Email',
            'nic as National ID',
            'industry_name as Industry Name',
            'industry_address as Industry Address',
            'industry_email as Industry Email',
            'industry_coordinate_x as GPS coordinate(X)',
            'industry_coordinate_y as GPS coordinate(Y) ',
            \DB::raw(
                '(CASE 
            WHEN industry_is_industry = "1" THEN "Industry Zone"            
            ELSE "Normal Zone" 
            END) as `Industry Zone`'
            ),
            'industry_investment as Industry Investment',
            'industry_start_date  as business Start Date',
            'industry_registration_no as Business Registration No',
            'industry_sub_category as Sub Category',
            'category_name as Category',
            'business_scale_name as Scale',
            'pradesheeyasaba_name as Pradesheeyasaba Name',
            'zone_name as Zone name',
            'assistance_first_name as AD First Name',
            'assistance_last_name as AD Last Name',
            'officer_first_name as EO First Name',
            'officer_last_name as EO Last Name',
            'epl_code as EPL code',
            \DB::raw(
                '(CASE 
            WHEN epl_count = "0" THEN "New"            
            ELSE "Renew" 
            END) as `EPL Status`'
            ),
            'epl_issue_date as Issue Date',
            'epl_expire_date as Expire Date',
            'epl_submitted_date as EPL Submitted Date',
            'epl_certificate_no as EPL Certificate No',
            'epl_count as Renew Count',
            'epl_rejected_date',
            'site_code',
            \DB::raw(
                '(CASE 
            WHEN site_count = "0" THEN "New"            
            ELSE "Extend" 
            END) as `Site Status`'
            ),
            'site_site_clearance_type as Site Clearance Type',
            \DB::raw(
                '(CASE 
            WHEN site_processing_status = "0" THEN "Pending"  
            WHEN site_processing_status = "1" THEN "Site Clearance"
            WHEN site_processing_status = "2" THEN "EIA"   
            WHEN site_processing_status = "2" THEN "IEE"       
            ELSE null 
            END) as `SC Processing Status`'
            ),
            'site_submit_date as SC Submit Date',
            'site_issue_date as SC Issue Date',
            'site_expire_date as SC Expire Date',
            'site_rejected_date as SC Rejected Date',
            'site_count as SC Count'

        );
        // echo $query->toSql();
        return  $query->get();
    }

    public function fileCountByPradesheeyaSaba()
    {
        return Client::join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->select('pradesheeyasabas.name', DB::raw('count(clients.id) as total'))
            ->groupBy('pradesheeyasaba_id')
            ->orderBy('pradesheeyasabas.name')
            ->get();
    }
    public function fileCountByEnvironmentOfficer()
    {
        return Client::join('environment_officers', 'clients.environment_officer_id', 'environment_officers.id')
            ->select('users.first_name', 'users.last_name', DB::raw('count(clients.id) as total'))
            ->join('users', 'environment_officers.user_id', 'users.id')
            ->groupBy('environment_officer_id')
            ->orderBy('users.first_name')
            ->get();
    }
    public function fileCountByIndustryCategory()
    {
        return Client::Join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->select('industry_categories.name', DB::raw('count(clients.id) as total'))
            ->groupBy('industry_category_id')
            ->orderBy('industry_categories.name')
            ->get();
    }
    public function fileCountByFileStatus()
    {
        return Client::select('file_status', DB::raw('count(clients.id) as total'))
            ->groupBy('file_status')
            ->orderBy('file_status')
            ->get();
    }

    public function find($id)
    {
        return Client::with('businessScale')
            ->with('industryCategory')
            ->with('pradesheeyasaba.zone')
            ->with('environmentOfficer.user')
            ->with('environmentOfficer.assistantDirector.user')
            ->with('siteClearenceSessions.siteClearances')
            ->with('epls')
            ->with('transactions.transactionItems.payment.paymentType')
            ->with('inspectionSessions.environmentOfficer.user')
            ->with('committees.commetyPool')
            ->with('minutes.user')
            ->with('fileLogs.user')
            ->findOrFail($id);
    }

    public function fileCountByIndustryCategoryAndLocalAuthority($from, $to)
    {
        return Client::RightJoin('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->LeftJoin('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->groupBy('industry_categories.id', 'pradesheeyasabas.id')
            ->select(DB::raw('count(clients.id) as total'), 'industry_categories.name as category_name', 'pradesheeyasabas.name as la_name')
            ->orderBy('pradesheeyasabas.name')
            ->orderBy('industry_categories.name')
            ->get();
    }
}
