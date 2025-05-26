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

Route::middleware('auth:api')->post('/epl/inspection/attach/id/{id}', 'InspectionSessionAttachmentController@createEPlInspection'); //   upload a new attachment
Route::middleware('auth:api')->post('/epl/inspection/attach/delete/id/{id}', 'InspectionSessionAttachmentController@destroy'); //   create a new inspection session
Route::middleware('auth:api')->get('/epl/inspection/attach/id/{id}', 'InspectionSessionAttachmentController@showEpl'); //   get all inspection attachments
//
