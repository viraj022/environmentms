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


Route::middleware('auth:api')->post('/inspection_remarks/{id}', 'InspectionRemarksController@create');
Route::middleware('auth:api')->get('/inspection_remarks/{id}', 'InspectionRemarksController@show');
Route::middleware('auth:api')->delete('/inspection_remark/{id}', 'InspectionRemarksController@destroy');
