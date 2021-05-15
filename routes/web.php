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

use Doctrine\DBAL\Schema\View;

Route::get('/', 'HomeController@index');

Auth::routes(['register' => false]);

// ui routs

Route::get('/attachments', 'AttachemntsController@index');
Route::get('/pradesheyasaba', 'PradesheeyasabaController@index');
Route::get('/industry_category', 'IndustryCategoryController@index');
Route::get('/payment_type', 'PaymentTypeController@index');
Route::get('/payments', 'PaymentsController@index');
Route::get('/payment_range', 'PaymentsController@index1');
Route::get('/zone', 'ZoneController@index');
Route::get('/assistant_director', 'AssistantDirectorController@index');
Route::get('/environment_officer', 'EnvironmentOfficerController@index');
Route::get('/attachment_map', 'ApplicationTypeController@index');
Route::get('/epl_register/id/{id}/type/{type}', 'EPLController@index');
Route::get('/epl_profile/client/{client}/profile/{profile}', 'EPLController@profile');
Route::get('/epl_profile/atachments/{epl_id}', 'EPLController@attachment_upload_view');
Route::get('/client_space', 'ClientController@index');
Route::get('/search_files', 'ClientController@search_files');
Route::get('/industry_files', 'ClientController@allClientsindex');
Route::get('/committee_pool', 'CommetyPoolController@index');
Route::get('/epl_assign', 'EnvironmentOfficerController@index2');
Route::get('/env_officer', 'EnvOfficerController@index');
Route::get('/remarks/epl/{id}', 'RemarkController@index');
Route::get('/inspection/epl/id/{id}', 'InspectionSessionController@index');
Route::get('/inspection/epl/remarks/id/{id}', 'InspectionRemarksController@index');
Route::get('/inspection/personals/id/{id}', 'InspectionPersonalController@index');
Route::get('/inspection_attachment/id/{id}', 'InspectionSessionAttachmentController@index');
Route::get('/application_payment', 'EPLController@index2');
Route::get('/epl_payments/id/{id}/type/{type}', 'EPLPaymentController@index');
Route::get('/certificate_approval/id/{id}', 'ApprovalLogController@index');
Route::get('/issue_certificate/id/{id}', 'EPLController@index3');
Route::get('/industry_profile/id/{id}', 'ClientController@index1');
Route::get('/renewal_page/id/{id}', 'EPLRenewController@index');
Route::get('/old_file_list', 'ClientController@indexOldFileList');
Route::get('/register_old_data/id/{id}', 'ClientController@indexOldDataReg');
Route::get('/schedule', 'EnvironmentOfficerController@index3');
Route::get('/update_client/id/{id}', 'ClientController@updateClient');
Route::get('/pending_certificates', 'ClientController@certificatesUi');
Route::get('/ad_pending_list', 'AssistantDirectorController@adPendingIndex');
Route::get('/certificate_perforation/id/{id}', 'ClientController@certificatePrefer');
Route::get('/director_pending_list', 'AssistantDirectorController@directorPendingListIndex');
Route::get('/site_clearance/client/{client}/profile/{profile}', 'SiteClearanceController@index');
Route::get('/expired_certificates', 'ClientController@expireCertificatesUi');
Route::get('/expired_cert', 'ClientController@expireCertUi');
Route::get('/committee/id/{id}', 'WebRouteController@indexCommittee');
Route::get('/committee_remarks/id/{id}', 'WebRouteController@indexCommitteeRemarks');
Route::get('/act_status/id/{file_id}', 'WebRouteController@actStatus');
Route::get('/old_data_summary', 'WebRouteController@oldDataSummary');
Route::get('/dashboard2', 'DashboardController@index');
Route::get('/report_dashboard', 'ReportController@index');
Route::get('/eo_locations', 'ClientController@eo_locations');
//ui routs
//dashboard
Route::get('/dashboard', function () {
  return view('welcome');
});

Route::get('/client_reg', function () {
  return view('client_space_expose');
});
Route::get('/client_space', 'ClientController@index');




//dashboard
