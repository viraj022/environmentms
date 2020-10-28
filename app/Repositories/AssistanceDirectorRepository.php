<?php

namespace App\Repositories;

use App\AssistantDirector;
use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use Carbon\Carbon;
use App\PaymentType;
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
class AssistanceDirectorRepository
{
    /**
     * Get File with has a site clearence in it
     * from date
     * To date
     * Instance => All , New , Extensions
     */
    public function getAssistanceDirectorWithZones()
    {
        return AssistantDirector::join('zones', 'assistant_directors.zone_id', 'zones.id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->where('assistant_directors.active_status', 1)
            ->select('assistant_directors.id', 'users.first_name', 'users.last_name', 'zones.name', 'zones.code')
            ->orderBy('zones.name')
            ->get();
    }
}
