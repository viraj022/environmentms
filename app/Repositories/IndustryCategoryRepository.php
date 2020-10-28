<?php

namespace App\Repositories;

use App\Client;
use App\FileView;
use App\IndustryCategory;
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
class IndustryCategoryRepository
{


    public function all()
    {
        return IndustryCategory::all();
    }
}
