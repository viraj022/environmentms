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

Route::middleware('auth:api')->get('/files/file_problem_status/id/{id}', 'ClientController@file_problem_status'); //  set file problem status
