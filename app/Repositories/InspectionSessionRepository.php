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
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->select('assistant_directors.id as ass_id', 'users.first_name', 'users.last_name', DB::raw('count(inspection_sessions.id) as total'))
            ->where('assistant_directors.active_status', 1)
            ->whereBetween('completed_at', [$from, $to])
            ->where('application_type', InspectionSession::TYPE_EPL)
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
        return $query->get();
        // dd($query->get()->toArray());
    }

    public function getSiteInspection($from, $to, $isNew)
    {
        $query =
            InspectionSession::join('site_clearence_sessions', 'inspection_sessions.profile_id', 'site_clearence_sessions.id')
            ->join('site_clearances', 'site_clearence_sessions.id', 'site_clearances.site_clearence_session_id')
            ->join('clients', 'inspection_sessions.client_id', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->select('assistant_directors.id as ass_id', 'users.first_name', 'users.last_name', DB::raw('count(inspection_sessions.id) as total'))
            ->where('assistant_directors.active_status', 1)
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
        return $query->get();
    }
}
