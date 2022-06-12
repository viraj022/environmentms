<?php

namespace App\Http\Controllers;

use App\SiteClearance;
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
}
