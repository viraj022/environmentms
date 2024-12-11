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


// Route::get('/site_clearance_report_alfa', 'ReportController@siteClearanceApplicationReport'); // don't delete this rout
/**
 * Site Clearance Report
 * from : from date 2020-01-01
 * to : to date 2020-05-05
 * type: type of report (all,new,extend)
 */
Route::get('/site_clearance_report/{from}/{to}/{type}', 'ReportController@siteClearanceApplicationReportBeta');

/**
 * EPL Report
 * from : from date 2020-01-01
 * to : to date 2020-05-05
 */
Route::get('/epl_report/{from}/{to}', 'ReportController@eplApplicationReport');
/**
 * EPL Log
 * from : from date 2020-01-01
 * to : to date 2020-05-05
 */
Route::get('/epl_application_log/{from}/{to}', 'ReportController@eplApplicationLog');
/**
 * Progress Report
 * from : from date 2020-01-01
 * to : to date 2020-05-05
 */
Route::get('/monthly_progress/{from}/{to}', 'ReportController@monthlyProgress');
/**
 * Field Officer Inspection Log
 * eo_id : environment officer id
 * from : from date 2020-01-01
 * to : to date 2020-05-05
 */
Route::get('/ep_inspection_report/{eo_id}/{from}/{to}', 'ReportController@eoInspectionReport');
/**
 * Field Officer Inspection Log
 * eo_id : environment officer id
 * from : from date 2020-01-01
 * to : to date 2020-05-05
 */
Route::get('/category_count_report/{from}/{to}', 'ReportController@categoryWiseCountReport');

Route::get('/category_count_report_two/{from}/{to}', 'ReportController@categoryLocalAuthorityWiseCountReport');


/**
 * get row data set of all files
 */

Route::get('/get_row_data', 'ReportController@RowReport');

/**
 * Field Officer Inspection Log
 * id file_id/client id
 */
Route::get('/file_summary/{id}', 'ReportController@fileSummary');

// Route::get('/testReportMul', 'ReportController@test');
/**
 * download all attachments of a file to a zip drive
 * client: client_id
 */

Route::get('/attachments/{client}', 'ReportController@downloadContents');

Route::get('/site_clearence_log/{from}/{to}', 'ReportController@siteClearanceApplicationLog');
Route::get('/warn_report', 'ReportController@warnReport');
Route::get('/pending_site_clear_report', 'ReportController@pendingSiteClearReport');//site clearence report
Route::get('/pending_epl_report', 'ReportController@pendingEplReport');//pending epl report
Route::get('/status_mismatch_report', 'ReportController@statusMismatchEpl');//status mismatch report
Route::get('/cert_missing_report', 'ReportController@certMissingReport');//status mismatch report
Route::get('/new_cs_report/{from}/{to}/{isNew}', 'ReportController@siteClearanceBySubmitDate')->name('new_cs_report');//new cs report
Route::get('/new_epl_report/{from}/{to}/{isNew}', 'ReportController@eplBySubmitDate')->name('new_epl_report');//new epl report

#certificate report
Route::get('/license_full_detail_report/{from}/{to}', 'ReportController@eplSiteClearenceReport')->name('license_full_detail_report');
