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

Route::middleware('auth:api')->post('/remarks/{id}', 'RemarkController@create'); 
Route::middleware('auth:api')->get('/remarks/{id}', 'RemarkController@show'); 
Route::middleware('auth:api')->delete('/remark/{id}', 'RemarkController@destroy'); 

