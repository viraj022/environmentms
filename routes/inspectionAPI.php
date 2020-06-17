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

Route::middleware('auth:api')->post('/epl/inspection/create/id/{id}', 'InspectionSessionController@createEplInspection'); //   create a new inspection session 

/*
{
    "schedule_date" :"2012-01-01",
    "remark":"das"
}
*/
Route::middleware('auth:api')->delete('/epl/inspection/delete/id/{id}', 'InspectionSessionController@destroyEplInspection'); //   delete a inspection session

/*
{
      "id": 1,
    "message": "true"
}
/*
