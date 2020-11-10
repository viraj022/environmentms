<?php
Route::middleware('auth:api')->post('/site_clearance_new', 'SiteClearanceController@create'); // save site clearance
Route::middleware('auth:api')->get('/site_clearance/{id}', 'SiteClearanceController@find'); //  get site clearance data
Route::middleware('auth:api')->patch('/site_clearance/processing_status/{siteClearanceSession}', 'SiteClearanceController@setProcessingStatus'); //  set site clearance processing status
/**
 * data
 * {
  "status": "1"   //0 => pending 1 =>  site clearance , 2 => eia 3 => ieea
    }
 */


/**
 * APis for manipulating  minutes records 
 */

Route::apiResource('/file_minutes', 'MinuteController');


Route::post('/tor/{site_clearence_session}', 'SiteClearanceController@uploadTor');
Route::post('/client_report/{site_clearence_session}', 'SiteClearanceController@clientReport');

Route::middleware('auth:api')->post('/client_clearance/extend/{siteClearance}', 'SiteClearanceController@extendSiteClearence');
