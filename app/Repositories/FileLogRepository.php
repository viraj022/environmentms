<?php

namespace App\Repositories;

use App\Committee;
use Carbon\Carbon;
use App\CommitteeRemark;
use App\FileLog;
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
class FileLogRepository
{

    public function getFIleLogById($client_id)
    {

        return FileLog::where('client_id', $client_id)->get();
    }
}
