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

Route::middleware('auth:api')->post('/approval/officer/reject/id/{id}', 'ApprovalLogController@approveOfficer'); // approve by env officer

Route::middleware('auth:api')->post('/approval/a_director/id/{id}', 'ApprovalLogController@approveAssitanceDirector'); // approve by assistance director

Route::middleware('auth:api')->post('/approval/director/id/{id}', 'ApprovalLogController@approveDirector'); // approve by  director

Route::middleware('auth:api')->post('/approval/officer/id/{id}', 'ApprovalLogController@rejectOfficer'); // reject by env officer

Route::middleware('auth:api')->post('/approval/a_director/reject/id/{id}', 'ApprovalLogController@rejectAssitanceDirector'); // reject by assistance director

Route::middleware('auth:api')->post('/approval/director/reject/id/{id}', 'ApprovalLogController@rejectDirector'); // reject by  director
