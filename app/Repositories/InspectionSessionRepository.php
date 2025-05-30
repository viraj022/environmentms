<?php

namespace App\Repositories;

use App\InspectionSession;
use App\SiteClearance;
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
class InspectionSessionRepository
{
    /**
     * Get File with has a site clearence in it
     * from date
     * To date
     * Instance => All , New , Extensions
     */

    public function getEPLInspection($from, $to, $isNew)
    {
        $query = InspectionSession::join('e_p_l_s', 'inspection_sessions.profile_id', 'e_p_l_s.id')
            ->join('clients', 'inspection_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.id as zone_id', 'zones.name as zone_name', DB::raw('count(inspection_sessions.id) as total'))
            ->whereBetween('completed_at', [$from, $to])
            ->where('application_type', InspectionSession::TYPE_EPL)
            ->groupBy('zones.id')
            ->orderBy('zones.name');

        switch ($isNew) {
            case 1:
                $query =  $query->where('count', 0);
                break;
            case 0:
                $query =  $query->where('count', '>', 0);
                break;
            default:
                abort(422, "invalid Argument for the switch HCE-log");
        }
        return $query->get()->keyBy('zone_id');
    }

    public function getSiteInspection($from, $to, $isNew)
    {
        $query = InspectionSession::join('site_clearence_sessions', 'inspection_sessions.profile_id', 'site_clearence_sessions.id')
            ->join('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
            ->join('clients', 'inspection_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->select('zones.name as zone_name', 'zones.id as zone_id', DB::raw('count(inspection_sessions.id) as total'))
            ->whereNotNull('completed_at')
            ->whereBetween('completed_at', [$from, $to])
            ->where('application_type', InspectionSession::SITE_CLEARANCE)
            ->groupBy('zones.id')
            ->orderBy('zones.name');
        // if()
        switch ($isNew) {
            case 1:
                $query =  $query->where('count', 0);
                break;
            case 0:
                $query =  $query->where('count', '>', 0);
                break;
            default:
                abort(422, "invalid Argument for the switch HCE-log");
        }

        return $query->get()->keyBy('zone_id');
    }
    public function getSiteInspectionDetails($from, $to, $eo_id = -1)
    {

        $querySite =
            InspectionSession::join('clients', 'inspection_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('environment_officers', 'inspection_sessions.environment_officer_id', 'environment_officers.id')
            ->join('users', 'environment_officers.user_id', 'users.id')
            /**
             * special join to get one one record from siteclearence table
             */
            ->join('site_clearence_sessions', function ($join) {
                $join->on('site_clearence_sessions.id', '=', DB::raw('(select id FROM site_clearence_sessions WHERE site_clearence_sessions.id = inspection_sessions.profile_id Limit 1)'));
            })
            ->select('completed_at', 'users.first_name', 'users.last_name', 'clients.industry_address', 'clients.file_no', 'inspection_sessions.application_type', 'site_clearence_sessions.code', 'pradesheeyasabas.name as pradesheeyasaba name', 'environment_officers.id')
            ->where('environment_officers.active_status', 1)
            ->whereBetween('completed_at', [$from, $to])
            ->where('application_type', InspectionSession::SITE_CLEARANCE)
            ->orderBy('completed_at');
        if ($eo_id > 0) {
            $querySite = $querySite->where('inspection_sessions.environment_officer_id', $eo_id);
        }
        $queryEPL =
            InspectionSession::join('clients', 'inspection_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('environment_officers', 'inspection_sessions.environment_officer_id', 'environment_officers.id')
            ->join('users', 'environment_officers.user_id', 'users.id')
            /**
             * special join to get one one record from e_p_l_s table
             */
            ->join('e_p_l_s', function ($join) {
                $join->on('e_p_l_s.id', '=', DB::raw('(select id FROM e_p_l_s WHERE e_p_l_s.id = inspection_sessions.profile_id Limit 1)'));
            })
            ->union($querySite)
            ->select('completed_at', 'users.first_name', 'users.last_name', 'clients.industry_address', 'clients.file_no', 'inspection_sessions.application_type', 'e_p_l_s.code', 'pradesheeyasabas.name as pradesheeyasaba_name', 'environment_officers.id')
            ->where('environment_officers.active_status', 1)
            ->whereBetween('completed_at', [$from, $to])
            ->where('application_type', InspectionSession::TYPE_EPL)
            ->orderBy('completed_at');
        if ($eo_id > 0) {
            $queryEPL = $queryEPL->where('inspection_sessions.environment_officer_id', $eo_id);
        }
        // dd($querySite->get()->toArray());

        // echo $query->toSql();
        return $queryEPL->get();
    }
}
