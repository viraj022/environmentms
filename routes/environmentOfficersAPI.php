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

Route::middleware('auth:api')->post('/epl/assign/id/{id}', 'EnvironmentOfficerController@assignEnvOfficer'); //   assign a epl to a officer


Route::middleware('auth:api')->get('/epl/assistance_director/{id}', 'EnvironmentOfficerController@getEplByAssistantDirector'); //   get epls by assistance director

Route::middleware('auth:api')->delete('/epl/remove/id/{id}', 'EnvironmentOfficerController@remove'); //   remove a epl

Route::middleware('auth:api')->get('/epl/envirnment_officers/', 'EnvironmentOfficerController@All'); //   get all environment officers

Route::middleware('auth:api')->post('/epl/assistance_director/{id}', 'EnvironmentOfficerController@getEplByAssistantDirector'); //   get epls by assistance director

// [
//     {
//         "id": 10,
//         "name": "Kurunegala Pradeshiya Sabha",
//         "code": "PKG",
//         "industry_category_id": 5,
//         "business_scale_id": 1,
//         "contact_no": "0710576923",
//         "address": "vxcv",
//         "email": "vxcvx@gmail.com",
//         "coordinate_x": "7.489050",
//         "coordinate_y": "80.349985",
//         "pradesheeyasaba_id": 10,
//         "is_industry": 0,
//         "investment": 4656,
//         "start_date": "2020-06-12 00:00:00",
//         "registration_no": "xcvxc",
//         "remark": "fsdfdsf",
//         "application_path": "uploads/EPL/8/application/1.png",
//         "created_at": "2020-02-25 09:22:18",
//         "updated_at": "2020-02-25 09:22:18",
//         "deleted_at": null,
//         "client_id": 1,
//         "site_clearance_file": null,
//         "environment_officer_id": null,
//         "zone_id": 1
//     }
// ]
Route::middleware('auth:api')->get('/epl/env_officer/{id}', 'EnvironmentOfficerController@getEplByEnvOfficer'); //   get epls by assistance director

// [
//     {
//         "id": 10,
//         "name": "Kurunegala Pradeshiya Sabha",
//         "code": "PKG",
//         "industry_category_id": 5,
//         "business_scale_id": 1,
//         "contact_no": "0710576923",
//         "address": "vxcv",
//         "email": "vxcvx@gmail.com",
//         "coordinate_x": "7.489050",
//         "coordinate_y": "80.349985",
//         "pradesheeyasaba_id": 10,
//         "is_industry": 0,
//         "investment": 4656,
//         "start_date": "2020-06-12 00:00:00",
//         "registration_no": "xcvxc",
//         "remark": "fsdfdsf",
//         "application_path": "uploads/EPL/8/application/1.png",
//         "created_at": "2020-02-25 09:22:18",
//         "updated_at": "2020-02-25 09:22:18",
//         "deleted_at": null,
//         "client_id": 1,
//         "site_clearance_file": null,
//         "environment_officer_id": null,
//         "zone_id": 1
//     }
// ]
Route::middleware('auth:api')->patch('/environment_officer/approve/{officer_id}/{file_id}', 'EnvironmentOfficerController@approveFile'); //   EO Approved file
Route::middleware('auth:api')->patch('/assistant_director/approve/{adId}/{file_id}', 'AssistantDirectorController@approveFile'); //   AD Approved FILE
Route::middleware('auth:api')->patch('/assistant_director/reject/{adId}/{file_id}', 'AssistantDirectorController@rejectFile'); //   AD Approved FILE
Route::middleware('auth:api')->patch('/environment_officer/reject/{officer_id}/{file_id}', 'EnvironmentOfficerController@rejectFile'); //   EO rejectFile

Route::middleware('auth:api')->patch('/environment_officer/approve_certificate/{officer_id}/{file_id}', 'EnvironmentOfficerController@approveCertificate'); //   EO Approved  certificate
Route::middleware('auth:api')->patch('/environment_officer/reject_certificate/{officer_id}/{file_id}', 'EnvironmentOfficerController@rejectCertificate'); //   EO reject certificate

Route::middleware('auth:api')->patch('/assistant_director/approve_certificate/{adId}/{file_id}', 'AssistantDirectorController@approveCertificate'); //   AD Approved certificate
Route::middleware('auth:api')->patch('/assistant_director/reject_certificate/{adId}/{file_id}', 'AssistantDirectorController@rejectCertificate'); //   AD Approved certificate

Route::middleware('auth:api')->patch('/assistant_director/reject_certificate/{adId}/{file_id}', 'AssistantDirectorController@rejectCertificate'); //   AD Approved certificate

Route::middleware('auth:api')->patch('/director/approve_certificate/{file_id}', 'AssistantDirectorController@derectorApproveCertificate'); //   Director Approved certificate


// {
  //   "id": 1,
  //   "message": "true"
  // }
  
  
  
  
  
  
  
  
  
  
  
  // hansana
  
  Route::middleware('auth:api')->patch('/director/reject/{file_id}', 'AssistantDirectorController@directorRejectCertificate'); //   Director reject certificate
  Route::middleware('auth:api')->patch('/director/hold/{file_id}', 'AssistantDirectorController@directorHoldCertificate'); //   Director hold certificate






// hansana