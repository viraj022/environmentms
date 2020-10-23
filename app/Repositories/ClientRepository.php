<?php

namespace App\Repositories;

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
}
