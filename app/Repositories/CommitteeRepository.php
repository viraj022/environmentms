<?php

namespace App\Repositories;

use App\Committee;
use App\SiteClearenceSession;
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
class CommitteeRepository
{

    public function all()
    {
        return Committee::with('siteClearenceSession.client')->get();
    }

    public function create($request)
    {
        $requestData = $request->all();
        // dd($requestData['site_clearence_session_id']);
        $requestData['client_id'] = SiteClearenceSession::findOrFail($requestData['site_clearence_session_id'])->client_id;
        $committee  = Committee::create($requestData);
        $committee->commetyPool()->sync($request->members);
        return  $committee == true;
    }

    public function update($request, $id)
    {
        // should remove client_id if present 
        // dd($id);
        $committee = Committee::findOrFail($id);
        $committeeResult = $committee->update($request->all());
        $committee->commetyPool()->sync($request->members);
        return  $committeeResult == true;
    }

    public function delete($id)
    {
        return  $committee = Committee::findOrFail($id)->delete() == true;
    }

    public function show($id)
    {
        return Committee::with('siteClearenceSession.client')->findOrFail($id);
    }
    public function getByAttribute($attribute, $value)
    {
        return Committee::with('siteClearenceSession.client')->where($attribute, $value)->get();
    }
}
