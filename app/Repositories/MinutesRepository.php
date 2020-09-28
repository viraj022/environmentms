<?php

namespace App\Repositories;

use App\Minute;
use Carbon\Carbon;
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
class MinutesRepository
{

    public function all()
    {
        return Minute::get();
    }

    public function save($requestData)
    {
        $minutes  = Minute::create($requestData);
        return  $minutes  == true;
    }

    public function update($request, $id)
    {

        $minutes  = Minute::findOrFail($id);
        $minutes = $minutes->update($request->all());
        return  $minutes == true;
    }

    public function delete($id)
    {
        return  Minute::findOrFail($id)->delete() == true;
    }

    public function show($id)
    {
        // return Committee::with('siteClearenceSession.client')->with('commetyPool')->findOrFail($id);
    }
    public function getByAttribute($attribute, $value)
    {
        // return Committee::with('siteClearenceSession.client')->with('commetyPool')->where($attribute, $value)->get();
    }
}
