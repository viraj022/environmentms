<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/files/old/{count}', 'ClientController@getOldFiles'); //   get old files
/*
[
    {
        "id": 6,
        "first_name": "dialog",
        "last_name": "Pvt Ltd",
        "address": null,
        "contact_no": null,
        "email": null,
        "nic": null,
        "password": "$2y$10$2dF7aXZj7LkP6hCuCp.rzOXkStNdDbEydo7WvYRaKBLymUSdT5b2i",
        "api_token": "xeDeKtOzBdxLG27HDW8uuKXa7UzQ0LhazJcyChMtplRXPu3s7nZ5oRqOhI3GadeXlIr0TGbATVM3a8Cs",
        "created_at": "2020-08-04 08:56:19",
        "updated_at": "2020-08-04 09:03:24",
        "deleted_at": null,
        "industry_name": "dialog",
        "industry_category_id": 5,
        "business_scale_id": 1,
        "industry_contact_no": "0710576923",
        "industry_address": "3000",
        "industry_email": null,
        "industry_coordinate_x": "7.487518",
        "industry_coordinate_y": "80.346852",
        "pradesheeyasaba_id": 10,
        "industry_is_industry": 1,
        "industry_investment": 50000,
        "industry_start_date": "2020-08-04 00:00:00",
        "industry_registration_no": "ABC/VR/8585",
        "application_path": "uploads/industry_files/6/application/1596531804.png",
        "environment_officer_id": null,
        "file_01": "uploads/industry_files/6/application/1596531562.png",
        "file_02": "uploads/industry_files/6/application/1596531579.png",
        "file_03": null,
        "file_no": "PEA/PKG/AG/S/06/2020",
        "assign_date": null,
        "is_working": 1,
        "is_old": 0
    }
]
*/

Route::middleware('auth:api')->post('/epl/old/industry/{id}', 'EPLController@saveOldData'); //   save a old epl

/*
  "epl_code" : "EPL/2020/rt/ty8",
  "remark" : "hansana",
  "issue_date" :"2020-01-01",
  "expire_date" : "2020-05-07",
  "certificate_no" : "ABC/7895",
  "count" : "0",
  "submit_date" : "2020-01-01",
  "file" : ""
*/

Route::middleware('auth:api')->post('/epl/old/epl/{id}', 'EPLController@updateOldData'); //   update a old epl

/*
  "epl_code" : "EPL/2020/rt/ty8",
  "remark" : "hansana",
  "issue_date" :"2020-01-01",
  "expire_date" : "2020-05-07",
  "certificate_no" : "ABC/7895",
  "count" : "0",
  "submit_date" : "2020-01-01",
  "file" : ""
*/
Route::middleware('auth:api')->delete('/epl/old/epl/{id}', 'EPLController@deleteOldData'); //   delete a old epl

/*
{
    "id": 1,
    "message": "true"
}
*/

Route::middleware('auth:api')->post('/old/attachments/{id}', 'OldFilesController@create'); //   add old attachments

/*
{
    "id": 1,
    "message": "true"
}
*/


Route::middleware('auth:api')->delete('/old/attachments/{id}', 'OldFilesController@delete'); //   delete old attachments

/*
{
    "id": 1,
    "message": "true"
}
*/




Route::middleware('auth:api')->post('/old/industry/{id}', 'ClientController@markOldFinish'); //   mark old data entry finish
/*
{
    "id": 1,
    "message": "true"
}
*/

Route::middleware('auth:api')->get('/old/industry/{id}', 'ClientController@getOldFilesDetails'); //   get old file details
/*
{
    "id": 1,
    "message": "true"
}
*/


/// apis for site clearance


Route::middleware('auth:api')->get('/old/site_clearance/industry/{id}', 'ClientController@getOldSiteClearanceData'); //   get old side clearance file detail
/*
{
    "id": 1,
    "message": "true"
}
*/

Route::middleware('auth:api')->post('/site_clearance/old/file/{id}', 'SiteClearanceController@saveOldData'); //   save a old site clearance

/*
  "code" : "EPL/2020/rt/ty90",
  "remark" : "hansana",
  "issue_date" :"2020-01-01",
  "expire_date" : "2020-05-07",
  "count" : "0",
  "submit_date" : "2020-01-01",
  "file" : "",
  "type" : ""
*/
/*

type should be one of the following

Site Clearance
Telecommunication
Schedule Waste'


*/


Route::middleware('auth:api')->post('/site_clearance/old/site_clearance_session/{id}', 'SiteClearanceController@updateOldData'); //   update site clearance



/*
  "code" : "EPL/2020/rt/ty90",
  "remark" : "hansana",
  "issue_date" :"2020-01-01",
  "expire_date" : "2020-05-07",
  "count" : "0",
  "submit_date" : "2020-01-01",
  "file" : "",
*/
Route::middleware('auth:api')->delete('/site_clearance/old/site_clearance_session/{id}', 'SiteClearanceController@deleteOldData'); //   delete old site clearance data



/*
 {
    "id": 1,
    "message": "true"
}
*/

Route::middleware('auth:api')->post('/old/unconfirm_industry/{id}', 'ClientController@markOldUnfinish');


Route::middleware('auth:api')->get('/old/confirmed_clients', 'ClientController@getConfirmedClients');
