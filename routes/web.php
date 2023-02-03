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

use App\Http\Controllers\CashierController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\ReportController;
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
Route::get('/industry_files', 'ClientController@allClientsindex')->middleware('auth');
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
Route::get('/industry_profile/id/{id}', 'ClientController@index1')->name('industry_profile.find');
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
Route::get('/confirmed_files', 'ClientController@confirmedFiles');
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

Route::get('/reverse_confirm', 'EPLController@index4');

Route::get('/eo_report', function () {
    return view('eo_report');
});
Route::get('/file_progress_report', 'ReportController@fileProgressReport');

Route::get('/director_approved_list', 'AssistantDirectorController@directorApprovedListIndex');
Route::get('/reset_count', 'ResetSettingsController@index');
Route::get('/complains', 'ComplainController@index');
Route::get('/complain_profile/id/{id}', 'ComplainController@complainProfile');
Route::get('/letter_maker', 'WebDocumentController@index');
Route::get('/letters', 'WebDocumentController@letters');
Route::get('/get_letter/letter/{letter_id}', 'WebDocumentController@get_letter');
Route::get('/get_letter_content/letter/{letter_id}', 'WebDocumentController@get_letter_content');
Route::get('/letter_template', 'WebDocumentController@letterTemplatePage');
Route::get('/load_temp/id/{id}', 'WebDocumentController@letterTempById');
Route::get('/show/{userNotification}', 'UserNotificationsController@show')->name('userNotification.show');
Route::get('/notifications/all', 'UserNotificationsController@index')->name('userNotification.all');
Route::get('/warning_letters', 'WarningLetterController@index')->name('warning_letters.index');
Route::get('/warn_view/id/{warn_let_id}', 'WarningLetterController@warnLetView')->name('warning_letters.view');
Route::get('/expired_epl', 'ClientController@expiredEplView');
Route::get('/expired_epl_data', 'ClientController@getExpiredEpl');
Route::get('/pending_expired_cert', 'ClientController@getPendingExpiredView');
Route::get('/warning_letter_log', 'WarningLetterController@warningLetterLog');

Route::get('/inspection_site_report/{id}', 'InspectionController@siteInspectionReportView')
    ->name('inspection_site_report');

Route::get('/inspection_site_report/{id}', 'InspectionController@siteInspectionReportView')->name('inspection_site_report');

//file letters
Route::get('/file_letters/id/{id}', 'FileLetterController@index')->name('file.letter.view');
Route::get('/create_file_letters/id/{id}', 'FileLetterController@createFileLetter')->name('create.file.letter');

Route::post('/save_letter', 'FileLetterController@storeFileLetter')->name('store.file.letter');

//update file letter
Route::get('/edit_letter/letter_id/{client_id}/{letter_id}', 'FileLetterController@editLetterView')->name('file.letter.edit.view');
Route::post('/edit_letter/letter_id/{client_id}/{letter_id}', 'FileLetterController@editFileLetter')->name('edit.file.letter');

//view file letter
Route::get('/view_letter/letter/{letter}', 'FileLetterController@viewFileLetter')->name('view.file.letter');

//file letter minutes
Route::get('/letter_minutes/letter/{letter_id}', 'FileLetterController@viewLetterMinuest')->name('view.file.letter.minutes');
Route::post('/save_letter_minutes/{letter_id}', 'FileLetterController@storeFileLetterMinutes')->name('store.file.letter.minutes');
Route::get('/letter_minutes_view/{letter}', 'FileLetterController@viewLetterMinutes')->name('view.letter.minutes');

//assign file letters
Route::get('/letter_assign/letter_id/{letter}', 'FileLetterController@viewFileLetterAssign')->name('view.file.letter.assign');
Route::post('/save_letter_assign/letter_id/{letter}', 'FileLetterController@storeFileLetterAssign')->name('store.file.letter.assign');

Route::post('/file_letter_completed/{letter}', 'FileLetterController@storeLetterCompleted')->name('store.letter.completed');

Route::post('/letter_finalize/{letter}', 'FileLetterController@letterFinalize')->name('letter.finalize');

Route::delete('/file_letter_delete/{letter}', 'FileLetterController@deleteLetter')->name('letter.delete');

//completed files
Route::get('/completed_files', [ReportController::class, 'viewCompletedFiles'])
    ->name('completed-files-index');
Route::post('/completed_files', [ReportController::class, 'viewCompletedFiles'])
    ->name('completed-files-list');

//complains report
Route::get('/complains_report', [ComplainController::class, 'viewComplainReport'])
    ->name('complains-report');


//cashier
Route::middleware('auth')->group(function () {
    Route::get('/cashier', [CashierController::class,  'newCashier'])
        ->name('cashier-index');

    Route::get('/view-invoice/{invoice}', 'CashierController@viewInvoice')
        ->name('view-invoice');

    Route::get('/get-transactions', 'CashierController@loadTransactions')
        ->name('load-transactions-table');

    Route::post('/cancel-transaction/{transaction}', 'CashierController@cancelTransaction');

    Route::post('/generate-invoices', 'CashierController@generateInvoice');

    Route::get('/print-invoice/{invoice}', 'CashierController@printInvoice')
        ->name('print-invoice');

    Route::get('/print-transactions-invoice/{invoice}', 'CashierController@printBulkTransactionsInvoice')
        ->name('print-transactions-invoice');

    #tax rate change
    Route::get('/edit-tax-rate', 'CashierController@editTaxRate')->name('change-tax-rate-view');
    Route::post('/edit-tax-rate', 'CashierController@changeTaxRate')->name('change-tax-rate');

    #invoices view
    Route::get('/invoices', 'CashierController@loadInvoices')->name('invoice-list');
    Route::post('/invoices', 'CashierController@loadInvoicesByDate')->name('invoice-list-by-date');
    Route::post('/cancel-invoice/{invoice}', 'CashierController@cancelInvoice')->name('invoice-cancel');

    Route::get('/cancel-invoices-list', 'CashierController@canceledInvoiceList')->name('canceled-invoice-list');
    Route::post('/cancel-invoices-list', 'CashierController@canceledInvoicesByDate')->name('canceled-invoice-list-by-date');

    Route::get('/income-report', 'CashierController@incomeReport')->name('income-report');
    // Route::post('/income-report-by-date', 'CashierController@incomeByDate')->name('income-report-by-date');

    Route::post('/income-report-by-date', 'CashierController@incomeReportNew')->name('income-report-by-date-new');

    //set profile payments
    Route::get('/profile-payments/{client}', 'ClientController@setProfilePayments')->name('set-profile-payments');
    Route::post('/profile-payments-set/client/{client}/{invoice}', 'ClientController@setPayment')->name('set-payment-to-client');
});
