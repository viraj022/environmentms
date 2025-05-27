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

// drivers
Route::middleware('auth:api')->get('/committee', 'CommetyPoolController@show'); // get committees

Route::middleware('auth:api')->post('/committee', 'CommetyPoolController@create'); //  insert committee

Route::middleware('auth:api')->post('/committee/id/{id}', 'CommetyPoolController@store'); // update committee

Route::middleware('auth:api')->get('/committee/id/{id}', 'CommetyPoolController@find'); // get A committee by id

Route::middleware('auth:api')->post('/committee/delete/id/{id}', 'CommetyPoolController@destroy'); // get A committee

Route::middleware('auth:api')->get('/committee/is_available/nic/{nic}', 'CommetyPoolController@uniqueNic'); // get A driver
