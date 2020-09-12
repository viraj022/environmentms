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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });

//api
Route::middleware('auth:api')->get('/files/all/officer/id/{id}', 'ClientController@getAllFiles'); // get all files by environment officer


Route::middleware('auth:api')->get('/files/working/officer/id/{id}', 'ClientController@workingFiles');  // get working files by environment officer

Route::middleware('auth:api')->get('/files/new/officer/id/{id}', 'ClientController@newlyAssigned'); //  get new files by environment officer


Route::middleware('auth:api')->get('/assistant_directors/level', 'AssistantDirectorController@getAssistanceDirectorsByLevel'); // get assistance director by logged user

Route::middleware('auth:api')->get('/environment_officer/level/assistant_director_id/{id}', 'EnvironmentOfficerController@getEnvironmentOfficersByLevel'); // get environment officer by logged user

Route::middleware('auth:api')->patch('/inspection/{inspectionNeed}/file/{id}', 'ClientController@markInspection'); // mark inspection need or not need

/*
values for inspectionNeed parameter
* needed
* no_needed
*/
/*

{
  "id": 1,
  "message": "true"
}

*/
Route::middleware('auth:api')->get('/files/need_inspection/officer/id/{id}', 'ClientController@inspection_needed_files'); //  get inspection needed files
Route::middleware('auth:api')->get('/files/need_inspection/pending/officer/id/{id}', 'ClientController@inspection_pending_needed_files'); //  get inspection needed files

Route::middleware('auth:api')->post('/files/file_problem_status/id/{id}', 'ClientController@file_problem_status'); //  set file problem status


Route::middleware('auth:api')->post('/files/status/id/{id}', 'ClientController@changeFileStatus'); //  set file problem status
/*
{
  "status_type":"file_approval",  // inspection , certificate_type , old_data , file_working , certificate , file_problem
  "status_code" : "approved",
  "status_value" : ""
}
*/

Route::middleware('auth:api')->get('/files/pending/assistance_director/{id}', 'ClientController@getAssistanceDirectorPendingList'); //  get director pending list
/*
[
    {
        "id": 21,
        "first_name": "ahan",
        "last_name": "last",
        "address": null,
        "contact_no": null,
        "email": null,
        "nic": null,
        "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
        "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
        "created_at": "2020-09-04 13:21:02",
        "updated_at": "2020-09-04 13:21:02",
        "deleted_at": null,
        "industry_name": "ahan",
        "industry_category_id": 84,
        "business_scale_id": 2,
        "industry_contact_no": null,
        "industry_address": "kurunegala",
        "industry_email": null,
        "industry_coordinate_x": "7.48905",
        "industry_coordinate_y": "80.349985",
        "pradesheeyasaba_id": 52,
        "industry_is_industry": 0,
        "industry_investment": 15000,
        "industry_start_date": "2020-09-15 00:00:00",
        "industry_registration_no": "ahan/2020",
        "application_path": null,
        "environment_officer_id": null,
        "file_01": null,
        "file_02": null,
        "file_03": null,
        "file_no": "PEA/0903/TCC/M/21/2020",
        "assign_date": null,
        "is_old": 1,
        "need_inspection": null,
        "file_problem_status": "pending",
        "file_problem_status_description": "",
        "file_status": -2,
        "cer_type_status": 0,
        "cer_status": 0,
        "old_files": [],
        "industry_category": {
            "id": 84,
            "name": "climbing",
            "code": "TC",
            "created_at": "2020-09-03 13:28:36",
            "updated_at": "2020-09-07 09:53:41"
        },
        "business_scale": {
            "id": 2,
            "name": "Medium- M(Industries of Category B)",
            "code": "M",
            "created_at": null,
            "updated_at": null
        },
        "pradesheeyasaba": {
            "id": 52,
            "name": "test03",
            "code": "0903",
            "created_at": "2020-09-03 06:11:27",
            "updated_at": "2020-09-03 06:11:27",
            "zone_id": 1
        },
        "environment_officer": null
    },
]
*/
Route::middleware('auth:api')->get('/files/pending/environment_officer/{id}', 'ClientController@getEnvironmentOfficerPendingList'); //  get environment officer pending list
/*
[
    {
        "id": 21,
        "first_name": "ahan",
        "last_name": "last",
        "address": null,
        "contact_no": null,
        "email": null,
        "nic": null,
        "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
        "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
        "created_at": "2020-09-04 13:21:02",
        "updated_at": "2020-09-04 13:21:02",
        "deleted_at": null,
        "industry_name": "ahan",
        "industry_category_id": 84,
        "business_scale_id": 2,
        "industry_contact_no": null,
        "industry_address": "kurunegala",
        "industry_email": null,
        "industry_coordinate_x": "7.48905",
        "industry_coordinate_y": "80.349985",
        "pradesheeyasaba_id": 52,
        "industry_is_industry": 0,
        "industry_investment": 15000,
        "industry_start_date": "2020-09-15 00:00:00",
        "industry_registration_no": "ahan/2020",
        "application_path": null,
        "environment_officer_id": null,
        "file_01": null,
        "file_02": null,
        "file_03": null,
        "file_no": "PEA/0903/TCC/M/21/2020",
        "assign_date": null,
        "is_old": 1,
        "need_inspection": null,
        "file_problem_status": "pending",
        "file_problem_status_description": "",
        "file_status": -2,
        "cer_type_status": 0,
        "cer_status": 0,
        "old_files": [],
        "industry_category": {
            "id": 84,
            "name": "climbing",
            "code": "TC",
            "created_at": "2020-09-03 13:28:36",
            "updated_at": "2020-09-07 09:53:41"
        },
        "business_scale": {
            "id": 2,
            "name": "Medium- M(Industries of Category B)",
            "code": "M",
            "created_at": null,
            "updated_at": null
        },
        "pradesheeyasaba": {
            "id": 52,
            "name": "test03",
            "code": "0903",
            "created_at": "2020-09-03 06:11:27",
            "updated_at": "2020-09-03 06:11:27",
            "zone_id": 1
        },
        "environment_officer": null
    },
]
*/
Route::middleware('auth:api')->get('/files/pending/director', 'ClientController@getDirectorPendingList'); //  get director pending list
/*
[
    {
        "id": 21,
        "first_name": "ahan",
        "last_name": "last",
        "address": null,
        "contact_no": null,
        "email": null,
        "nic": null,
        "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
        "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
        "created_at": "2020-09-04 13:21:02",
        "updated_at": "2020-09-04 13:21:02",
        "deleted_at": null,
        "industry_name": "ahan",
        "industry_category_id": 84,
        "business_scale_id": 2,
        "industry_contact_no": null,
        "industry_address": "kurunegala",
        "industry_email": null,
        "industry_coordinate_x": "7.48905",
        "industry_coordinate_y": "80.349985",
        "pradesheeyasaba_id": 52,
        "industry_is_industry": 0,
        "industry_investment": 15000,
        "industry_start_date": "2020-09-15 00:00:00",
        "industry_registration_no": "ahan/2020",
        "application_path": null,
        "environment_officer_id": null,
        "file_01": null,
        "file_02": null,
        "file_03": null,
        "file_no": "PEA/0903/TCC/M/21/2020",
        "assign_date": null,
        "is_old": 1,
        "need_inspection": null,
        "file_problem_status": "pending",
        "file_problem_status_description": "",
        "file_status": -2,
        "cer_type_status": 0,
        "cer_status": 0,
        "old_files": [],
        "industry_category": {
            "id": 84,
            "name": "climbing",
            "code": "TC",
            "created_at": "2020-09-03 13:28:36",
            "updated_at": "2020-09-07 09:53:41"
        },
        "business_scale": {
            "id": 2,
            "name": "Medium- M(Industries of Category B)",
            "code": "M",
            "created_at": null,
            "updated_at": null
        },
        "pradesheeyasaba": {
            "id": 52,
            "name": "test03",
            "code": "0903",
            "created_at": "2020-09-03 06:11:27",
            "updated_at": "2020-09-03 06:11:27",
            "zone_id": 1
        },
        "environment_officer": null
    }
]
*/
Route::middleware('auth:api')->get('/files/certificate_drafting', 'ClientController@getCertificateDraftingList'); //  get Certificate Drafting List
/*
[
    {
        "id": 21,
        "first_name": "ahan",
        "last_name": "last",
        "address": null,
        "contact_no": null,
        "email": null,
        "nic": null,
        "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
        "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
        "created_at": "2020-09-04 13:21:02",
        "updated_at": "2020-09-04 13:21:02",
        "deleted_at": null,
        "industry_name": "ahan",
        "industry_category_id": 84,
        "business_scale_id": 2,
        "industry_contact_no": null,
        "industry_address": "kurunegala",
        "industry_email": null,
        "industry_coordinate_x": "7.48905",
        "industry_coordinate_y": "80.349985",
        "pradesheeyasaba_id": 52,
        "industry_is_industry": 0,
        "industry_investment": 15000,
        "industry_start_date": "2020-09-15 00:00:00",
        "industry_registration_no": "ahan/2020",
        "application_path": null,
        "environment_officer_id": null,
        "file_01": null,
        "file_02": null,
        "file_03": null,
        "file_no": "PEA/0903/TCC/M/21/2020",
        "assign_date": null,
        "is_old": 1,
        "need_inspection": null,
        "file_problem_status": "pending",
        "file_problem_status_description": "",
        "file_status": -2,
        "cer_type_status": 0,
        "cer_status": 0,
        "old_files": [],
        "industry_category": {
            "id": 84,
            "name": "climbing",
            "code": "TC",
            "created_at": "2020-09-03 13:28:36",
            "updated_at": "2020-09-07 09:53:41"
        },
        "business_scale": {
            "id": 2,
            "name": "Medium- M(Industries of Category B)",
            "code": "M",
            "created_at": null,
            "updated_at": null
        },
        "pradesheeyasaba": {
            "id": 52,
            "name": "test03",
            "code": "0903",
            "created_at": "2020-09-03 06:11:27",
            "updated_at": "2020-09-03 06:11:27",
            "zone_id": 1
        },
        "environment_officer": null
    }
]
*/



Route::middleware('auth:api')->post('/start_drafting/id/{id}', 'ClientController@nextCertificateNumber'); //  start certificate drafting



/*
{
    "nextNumber": "000001"
}*/
