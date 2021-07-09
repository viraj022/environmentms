<?php

namespace App\Repositories;

//use App\EPL;
//use App\Client;
use App\Minute;
//use App\SiteClearance;
//use Carbon\Carbon;
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
class MinutesRepository {

    public static function all($file_id) {
//        $file =   Client::FindOrfail($file_id);
        $minutes = Minute::with('user')->where('file_id', $file_id)->get()->toArray();
//        $minutes =  $minutes->groupBy('file_type');
//        dd($minutes);
        $array = [];
        foreach ($minutes as $min) {
            $user = $min['user'];
            $array[] = array(
                'file_type' => $min['file_type'],
                'minute_description' => $min['minute_description'],
                'situation' => $min['situation'],
                'updated_at' => $min['updated_at'],
                'user' => $user['first_name'] . " " . $user['last_name'] . " (" . $user['user_name'] . ")",
            );
        }
        /*
          foreach ($minutes as $key => $value) {
          if ($key == Minute::EPL) {
          $grp =  $value->groupBy('file_type_id');
          foreach ($grp as $keyEPl => $valueEPL) {
          EPL::findOrFail($keyEPl);
          array_push($array, array("type" => "EPL", "Date" => '2020-01', 'minute_object' => $valueEPL->toArray()));
          }
          } else if ($key == Minute::SITE_CLEARANCE) {
          $grp =  $value->groupBy('file_type_id');
          foreach ($grp as $keySITE => $valueSITE) {
          SiteClearance::findOrFail($keySITE);
          array_push($array, array("type" => "Site Clearance", "Date" => '2020-01', 'minute_object' => $valueSITE->toArray()));
          }
          }
          }
         */
        return $array;
    }

    public function save($requestData) {
        $minutes = Minute::create($requestData);
        return $minutes == true;
    }

    public function update($request, $id) {

        $minutes = Minute::findOrFail($id);
        $minutes = $minutes->update($request->all());
        return $minutes == true;
    }

    public function delete($id) {
        return Minute::findOrFail($id)->delete() == true;
    }

    public function show($id) {
        // return Committee::with('siteClearenceSession.client')->with('commetyPool')->findOrFail($id);
    }

    public function getByAttribute($attribute, $value) {
        // return Committee::with('siteClearenceSession.client')->with('commetyPool')->where($attribute, $value)->get();
    }

}
