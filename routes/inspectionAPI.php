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
Route::middleware('auth:api')->get('/inspections/completed/file/id/{id}', 'InspectionSessionController@showInspectionsCompleted');   // show all pending inspections by file

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
Route::middleware('auth:api')->patch('/inspection/complete/id/{id}', 'InspectionSessionController@markComplete'); // make inspection complete
/**
 *  {
    "id": 1,
    "message": "true"
}
 */
Route::middleware('auth:api')->patch('/inspection/pending/id/{id}', 'InspectionSessionController@markPending'); // make inspection pending
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
