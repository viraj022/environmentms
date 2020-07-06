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

Route::middleware('auth:api')->get('/approval/id/{id}', 'ApprovalLogController@getLog'); // get approval log

Route::middleware('auth:api')->get('/approval/current/id/{id}', 'ApprovalLogController@current'); // get current approval status
/*{
    "id": 5,
    "type": "EPL",
    "type_id": 8,
    "officer_type": "a_director",
    "user_id": 1,
    "status": 0,
    "approve_date": "2020-07-02 11:15:27",
    "comment": "dsada",
    "created_at": "2020-07-02 11:15:27",
    "updated_at": "2020-07-02 11:15:27"
}
*/

Route::middleware('auth:api')->post('/approval/officer/id/{id}', 'ApprovalLogController@approveOfficer'); // approve by env officer

Route::middleware('auth:api')->post('/approval/a_director/id/{id}', 'ApprovalLogController@approveAssitanceDirector'); // approve by assistance director

Route::middleware('auth:api')->post('/approval/director/id/{id}', 'ApprovalLogController@approveDirector'); // approve by  director

Route::middleware('auth:api')->delete('/approval/officer/id/{id}', 'ApprovalLogController@rejectOfficer'); // reject by env officer

Route::middleware('auth:api')->delete('/approval/a_director/id/{id}', 'ApprovalLogController@rejectAssitanceDirector'); // reject by assistance director

Route::middleware('auth:api')->delete('/approval/director/id/{id}', 'ApprovalLogController@rejectDirector'); // reject by  director
