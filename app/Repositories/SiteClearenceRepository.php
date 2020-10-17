<?php

namespace App\Repositories;

use App\Client;
use App\Committee;
use Carbon\Carbon;
use App\CommitteeRemark;
use App\FileLog;
use App\SiteClearance;
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
        switch ($instance) {
            case  'All':

                return Client::with('siteClearenceSessions.siteClearances')
                    ->whereHas('siteClearenceSessions.siteClearances', function ($query) use ($from, $to) {
                        $query->whereBetween('submit_date', [$from, $to]);
                    })
                    ->get();
            case 'New':
                return Client::with('siteClearenceSessions.siteClearances')
                    ->whereHas('siteClearenceSessions.siteClearances', function ($query) use ($from, $to) {
                        $query->whereBetween('submit_date', [$from, $to])
                            ->where('count', 1);
                    })
                    ->get();
            case 'extend':
                return Client::with('siteClearenceSessions.siteClearances')
                    ->whereHas('siteClearenceSessions.siteClearances', function ($query) use ($from, $to) {
                        $query->whereBetween('submit_date', [$from, $to])
                            ->where('count', '>', 1);
                    })
                    ->get();
            default:
                abort('404', 'Report Instance Not Defined - Ceytech internal error log');
        }
    }
}
