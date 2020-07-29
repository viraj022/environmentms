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
Route::middleware('auth:api')->get('/files/all/officer/id/{id}', 'ClientController@getAllFiles');


Route::middleware('auth:api')->get('/files/working/officer/id/{id}', 'ClientController@workingFiles');

Route::middleware('auth:api')->get('/files/working/officer/id/{id}', 'ClientController@newlyAssigned');
