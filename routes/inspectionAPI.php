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

Route::middleware('auth:api')->post('/automatic_inspection/create/id/{id}', 'InspectionSessionController@createInspection'); //   create a new inspection session

/*
{
    "schedule_date" :"2012-01-01",
    "remark":"das"
}
*/


Route::middleware('auth:api')->delete('/inspection/delete/id/{id}', 'InspectionSessionController@destroyInspection'); //   delete a inspection session

/*
{
      "id": 1,
    "message": "true"
}
*/

Route::middleware('auth:api')->get('/inspections/file/id/{id}', 'InspectionSessionController@showInspections');   // show all inspections by file

/**
 *
 [
    {
        "id": 10,
        "profile_id": 7,
        "remark": null,
        "status": 0,
        "schedule_date": "2020-01-01 00:00:00",
        "deleted_at": null,
        "created_at": "2020-08-26 02:06:45",
        "updated_at": "2020-08-26 02:06:45",
        "application_type": "EPL",
        "client_id": 7,
        "inspection_remarks": [],
        "inspection_session_attachments": [],
        "inspection_personals": []
    }
]

 */


Route::middleware('auth:api')->get('/inspections/file/date/{date}/id/{id}', 'InspectionSessionController@showInspectionsByDate');   // show all inspections by schedule_date
/*
[
    {
        "id": 2,
        "profile_id": 4,
        "remark": "j",
        "status": 0,
        "schedule_date": "2020-08-24 00:00:00",
        "deleted_at": null,
        "created_at": "2020-08-17 07:13:26",
        "updated_at": "2020-08-17 07:13:26",
        "application_type": "",
        "client_id": 7,
        "inspection_remarks": [],
        "inspection_session_attachments": [],
        "inspection_personals": [],
        "client": {
            "id": 7,
            "first_name": "tyu",
            "last_name": null,
            "address": null,
            "contact_no": null,
            "email": null,
            "nic": null,
            "password": "$2y$10$rgH7jKSmJYG8ahT/wFhU7e6DjwVfAoYR3arL3lhgEFfZXzomc1JrO",
            "api_token": "whTYcFOm6LC1DagUoMrOUKKSMRiTpycysWnRntpo6kJ0RegHcyQA1kg9utoUMd8h9Rd2ZGTX5dmrk7Ue",
            "created_at": "2020-08-24 10:11:27",
            "updated_at": "2020-08-26 01:09:49",
            "deleted_at": null,
            "industry_name": "tyu",
            "industry_category_id": 23,
            "business_scale_id": 2,
            "industry_contact_no": "0710576923",
            "industry_address": "dasdsad",
            "industry_email": null,
            "industry_coordinate_x": "7.48905",
            "industry_coordinate_y": "80.349985",
            "pradesheeyasaba_id": 46,
            "industry_is_industry": 1,
            "industry_investment": 5661321,
            "industry_start_date": "2020-08-01 00:00:00",
            "industry_registration_no": "asdsadsadad",
            "application_path": "uploads/industry_files/7/application/1598265083.jpeg",
            "environment_officer_id": 20,
            "file_01": "uploads/industry_files/7/application/file1/1598264709.jpeg",
            "file_02": "uploads/industry_files/7/application/file2/1598264714.jpeg",
            "file_03": "uploads/industry_files/7/application/file3/1598264720.jpeg",
            "file_no": "PEA/testps/CR/M/07/2020",
            "assign_date": "2020-08-24 10:33:25",
            "is_working": 1,
            "is_old": 0,
            "need_inspection": "Inspection Needed"
        }
    }
]

*/
Route::middleware('auth:api')->get('/inspections/pending/file/id/{id}', 'InspectionSessionController@showInspectionsPending');   // show all pending inspections by file

/**
 *
 [
    {
        "id": 10,
        "profile_id": 7,
        "remark": null,
        "status": 0,
        "schedule_date": "2020-01-01 00:00:00",
        "deleted_at": null,
        "created_at": "2020-08-26 02:06:45",
        "updated_at": "2020-08-26 02:06:45",
        "application_type": "EPL",
        "client_id": 7,
        "inspection_remarks": [],
        "inspection_session_attachments": [],
        "inspection_personals": []
    }
]

 */
Route::middleware('auth:api')->get('/inspections/completed/file/id/{id}', 'InspectionSessionController@showInspectionsCompleted');   // show all compleate inspections by file

/**
 *
 [
    {
        "id": 10,
        "profile_id": 7,
        "remark": null,
        "status": 0,
        "schedule_date": "2020-01-01 00:00:00",
        "deleted_at": null,
        "created_at": "2020-08-26 02:06:45",
        "updated_at": "2020-08-26 02:06:45",
        "application_type": "EPL",
        "client_id": 7,
        "inspection_remarks": [],
        "inspection_session_attachments": [],
        "inspection_personals": []
    }
]

 */

Route::middleware('auth:api')->get('/inspection/id/{id}', 'InspectionSessionController@find'); // find one inspection by inspection id
/**
 *  {
        "id": 10,
        "profile_id": 7,
        "remark": null,
        "status": 0,
        "schedule_date": "2020-01-01 00:00:00",
        "deleted_at": null,
        "created_at": "2020-08-26 02:06:45",
        "updated_at": "2020-08-26 02:06:45",
        "application_type": "EPL",
        "client_id": 7,
        "inspection_remarks": [],
        "inspection_session_attachments": [],
        "inspection_personals": []
    }
 */
Route::middleware('auth:api')->post('/inspection/complete/id/{id}', 'InspectionSessionController@markComplete'); // make inspection complete
/**
 *  {
    "id": 1,
    "message": "true"
}
 */
Route::middleware('auth:api')->post('/inspection/pending/id/{id}', 'InspectionSessionController@markPending'); // make inspection pending
/**
 *  {
    "id": 1,
    "message": "true"
}
 */


//Inspection Personal API Open

Route::middleware('auth:api')->post('/inspection/personal/create/id/{id}', 'InspectionPersonalController@create');
Route::middleware('auth:api')->get('/inspection/personal/id/{id}', 'InspectionPersonalController@find');
Route::middleware('auth:api')->get('/inspections/personal/id/{id}', 'InspectionPersonalController@showInspectionsPersonal');
Route::middleware('auth:api')->delete('/inspections/personal/remove/id/{id}', 'InspectionPersonalController@destroy');







//Inspection Personal API End
