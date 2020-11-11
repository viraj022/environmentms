<?php

namespace App\Repositories;

use App\Pradesheeyasaba;
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
class PradesheeyasabaRepository
{


    public function all()
    {
        return Pradesheeyasaba::orderBy('name')->get();
    }
}
