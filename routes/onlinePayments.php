<?php
# online requests

use App\Http\Controllers\OnlinePaymentController;

Route::get('/online-requests', 'OnlineRequestController@index')
    ->name('online-requests.index');

# renewals
Route::get('/online-requests/renewal/{renewal}/view-attachment', 'OnlineRequestController@viewRenewalAttachmentFile')
    ->name('online-requests.renewal.view-attachment');
Route::get('/online-requests/renewal/{renewal}', 'OnlineRequestController@viewRenewalRequest')
    ->name('online-requests.renewal.view');
Route::get('/renewals/client-by-fileno', 'OnlineRequestController@getClientByOldFileNumber')
    ->name('renewals.client-by-fileno');
Route::post('/renewal-update-client/{renewal}', 'OnlineRequestController@updateRenewalRequest')
    ->name('renewals.update-client');

Route::post('/online-request/{onlineRequest}/send-link', 'OnlineRequestController@sendPaymentLink')
    ->name('online-request.payment.sendlink');
# new-applications
Route::get('/online-requests/new-application/{newApplication}', 'OnlineRequestController@viewNewApplicationRequest')
    ->name('online-requests.new-application.view');
Route::post('/online-requests/new-application/reject/{newApplication}', 'OnlineRequestController@rejectNewRequest')
    ->name('online-requests.new-application.reject');

# online-payment-link-recieve
Route::get('/online-request/pay', 'OnlinePaymentController@receiveRenewalPaymentLink')
    ->name('online-request.pay');

Route::post('/client_space', 'ClientController@fromOnlineNewApplicationRequest')->name('client-space');

Route::get('/payment/return/{onlinePayment}', 'OnlinePaymentController@receivePaymentReturn')
    ->name('payment-result.return');

Route::get('/payment/canceled/{paymentRequest}', 'OnlinePaymentController@receivePaymentCancelled')
    ->name('payment-result.cancelled');
Route::get('/payment/{paymentRequest}/receipt', 'OnlinePaymentController@generateReceipt')
    ->name('payment-request.receipt');

# generate online payments for transactions
Route::get('/transaction/create-online-payment/{transaction}', 'OnlinePaymentController@createForTransaction')
    ->name('transactions.create-online-payment');
Route::post(
    '/transactions/payment/send-link/{transaction}',
    'OnlineRequestController@registerAndSendOnlinePaymentLinksForTransaction'
)->name('transactions.payment.send-link');


Route::get('/online-request/tree-felling', [OnlinePaymentController::class, 'onlineTreeFellingRequests'])
    ->name('online-tree-felling');
