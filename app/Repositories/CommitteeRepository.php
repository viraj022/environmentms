<?php

namespace App\Repositories;

use App\Committee;
use Carbon\Carbon;
use App\CommitteeRemark;
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
        return Committee::with('siteClearenceSession.client')->with('commetyPool')->findOrFail($id);
    }
    public function getByAttribute($attribute, $value)
    {
        return Committee::with('siteClearenceSession.client')->with('commetyPool')->where($attribute, $value)->get();
    }
    public function getRemarkByCommittee($committee)
    {
        // dd($committee);
        return Committee::with('committeeRemarks.user')->findOrFail($committee)->committeeRemarks;
    }
    public function showRemark($remark)
    {
        // dd($committee);
        return CommitteeRemark::with('user')->findOrFail($remark);
    }

    // committee remarks ----
    public function saveRemarksByCommittee($committee, $requestData, $file = null, $extension)
    {
        return  DB::transaction(function () use ($committee, $requestData, $file, $extension) {
            $committee = Committee::findOrFail($committee);
            if ($file != null) {
                $requestData['path'] = $this->uploadAttachment($file, $extension, $committee);
            }
            $committeeRemark  = CommitteeRemark::create($requestData);
            return  $committeeRemark == true;
        });
    }

    public function updateRemarksByCommittee($remarks, $requestData)
    {
        $committeeRemark = CommitteeRemark::findOrFail($remarks);
        $committeeRemark  = $committeeRemark::update($requestData);
        return  $committeeRemark == true;
    }
    public function deleteRemarksByCommittee($remarks)
    {
        $committeeRemark = CommitteeRemark::findOrFail($remarks);
        $committeeRemark  = $committeeRemark->delete();
        return  $committeeRemark == true;
    }

    // committee attachments ---------


    public function uploadAttachment($file, $extension, $committee)
    {
        // dd($committee);
        if ($file != null) {
            $file_name = Carbon::now()->timestamp . '.' . $extension;
            $fileUrl = '/uploads/industry_files/committee/' . $committee->siteClearenceSession->id . '/' . $committee->site_clearence_session_id . '/' . $committee->id . '/application';
            $storePath = 'public' . $fileUrl;
            $path = $file->storeAs($storePath, $file_name);
            return "storage" . $fileUrl . "/" . $file_name;
        }
    }
}
