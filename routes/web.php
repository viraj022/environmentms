<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/', 'HomeController@index');
Route::get('/survey', 'SurveyTitleController@show');
Route::get('/survey_view/id/{id}', 'SurveyTitleController@view');
Route::get('/survey_session', 'SurveySessionController@load');

/*
|plant
|
|
 */
Route::get('/plant', 'PlantController@index');
Route::Post('/plant', 'PlantController@create');
Route::get('/plant/id/{id}', 'PlantController@edit');
Route::put('/plant/id/{id}', 'PlantController@store');
Route::delete('/plant/id/{id}', 'PlantController@destroy');

/*
|transfer station
|
|
 */
Route::get('/transfer_station', 'TransferStationController@index');
Route::Post('/transfer_station', 'TransferStationController@create');
Route::get('/transfer_station/id/{id}', 'TransferStationController@edit');
Route::put('/transfer_station/id/{id}', 'TransferStationController@store');
Route::delete('/transfer_station/id/{id}', 'TransferStationController@destroy');
/*
|dump site
|
|
 */
Route::get('/dumpsite', 'DumpSiteController@index');
Route::Post('/dumpsite', 'DumpSiteController@create');
Route::get('/dumpsite/id/{id}', 'DumpSiteController@edit');
Route::put('/dumpsite/id/{id}', 'DumpSiteController@store');
Route::delete('/dumpsite/id/{id}', 'DumpSiteController@destroy');
/*
|sampathkendraya
|
|
 */
Route::get('/sampath', 'SamapthKendrayaController@index');
Route::Post('/sampath', 'SamapthKendrayaController@create');
Route::get('/sampath/id/{id}', 'SamapthKendrayaController@edit');
Route::put('/sampath/id/{id}', 'SamapthKendrayaController@store');
Route::delete('/sampath/id/{id}', 'SamapthKendrayaController@destroy');

/*
|suboffice
|
|
 */
Route::get('/suboffice', 'SubofficeController@index');
Route::Post('/suboffice', 'SubofficeController@create');
Route::get('/suboffice/id/{id}', 'SubofficeController@edit');
Route::put('/suboffice/id/{id}', 'SubofficeController@store');
Route::delete('/suboffice/id/{id}', 'SubofficeController@destroy');
/*
|ward
|
|
 */
Route::get('/ward', 'WardController@index');
Route::Post('/ward', 'WardController@create');
Route::get('/ward/id/{id}', 'WardController@edit');
Route::put('/ward/id/{id}', 'WardController@store');
Route::delete('/ward/id/{id}', 'WardController@destroy');

Route::get('/province/{id}', 'SurveyViewController@province');
Route::get('/la/{id}', 'SurveyViewController@localAuthorty');
/*
|vehicle
|
|
 */
Route::get('/vehicle', 'VehicleController@index');
Route::Post('/vehicle', 'VehicleController@create');
Route::get('/vehicle/id/{id}', 'VehicleController@edit');
Route::put('/vehicle/id/{id}', 'VehicleController@store');
Route::delete('/vehicle/id/{id}', 'VehicleController@destroy');

Auth::routes(['register' => false]);
