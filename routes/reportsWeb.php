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


Route::get('/site_clearance_report_alfa', 'ReportController@siteClearanceApplicationReport');
Route::get('/site_clearance_report', 'ReportController@siteClearanceApplicationReportBeta');
Route::get('/epl_report', 'ReportController@eplApplicationReport');
Route::get('/epl_application_log', 'ReportController@eplApplicationLog');
Route::get('/monthly_progress', 'ReportController@monthlyProgress');
// Route::get('/testReportMul', 'ReportController@test');
