<?php

namespace App\Repositories;

use App\Client;
use App\FileView;
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
}
