<?php

namespace App\Repositories;

use App\AssistantDirector;
use App\EPL;
use App\Client;
use App\FileLog;
use App\Committee;
use App\EnvironmentOfficer;
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
class EnvironmentOfficerRepository
{
    /**
     * Get File with has a site clearence in it
     * from date
     * To date
     * Instance => All , New , Extensions
     */
    public function getOfficerDetails($id)
    {
        return EnvironmentOfficer::with('user')->where('id', $id)->where('active_status', 1)->first();
    }
}
