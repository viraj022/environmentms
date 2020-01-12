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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//api
Route::middleware('auth:api')->post('/rolls/rollId/{id}', 'RollController@store');
Route::middleware('auth:api')->delete('/rolls/rollId/{id}', 'RollController@destroy');
Route::middleware('auth:api')->get('/rolls/levelId/{id}', 'LevelController@rollsByLevel')->name('rolls_by_level');
Route::middleware('auth:api')->get('/rolls/rollPrivilege/{id}', 'RollController@getRollPrevilagesById')->name('Previlages_by_rollId');
Route::middleware('auth:api')->get('/user/Privileges/{id}', 'UserController@previlagesById');
Route::middleware('auth:api')->get('/rolls/privilege/add', 'RollController@PrevilagesAdd')->name('Previlages_add');
Route::middleware('auth:api')->get('/user/privilege/add/{id}', 'UserController@PrevilagesAddById');
Route::middleware('auth:api')->get('/user/activity/{id}', 'UserController@activeStatus');
Route::middleware('auth:api')->get('/level/institutes/id/{id}', 'LevelController@instituteById')->name('level_institues_by_id');
