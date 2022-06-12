<?php

namespace App\Http\Controllers;

use App\SiteClearance;
use App\SiteClearenceSession;
use Illuminate\Http\Request;

class SiteClearanceFixController extends Controller
{
    public function fixIssueDate()
    {
        $siteClearance = SiteClearance::select('site_clearence_sessions.issue_date AS siteIssueDate', 'site_clearances.id')
            ->join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', '=', 'site_clearence_sessions.id')
            ->where('count', '=', 0)
            ->whereNotNull('site_clearence_sessions.issue_date')
            ->whereNull('site_clearances.issue_date')
            ->get();
        // ->toSql();
        $count = 0;
        foreach ($siteClearance as $key => $value) {
            $siteClearance = SiteClearance::find($value->id);
            $siteClearance->issue_date = $value->siteIssueDate;
            $siteClearance->save();
        }
        return $count;
        // return $siteClearance;
    }
    public function fixSessionIssueDate()
    {
        $sClearance = SiteClearance::select('site_clearances.issue_date AS siteIssueDate', 'site_clearances.site_clearence_session_id')
            ->join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', '=', 'site_clearence_sessions.id')
            ->whereNotNull('site_clearances.issue_date')
            ->whereNull('site_clearence_sessions.issue_date')
            ->get();

        $count = 0;
        foreach ($sClearance as $key => $value) {
            $session = SiteClearenceSession::find($value->site_clearence_session_id);
            $session->issue_date = $value->siteIssueDate;
            $session->save();
            $count++;
        }
        return $count;
    }
}
