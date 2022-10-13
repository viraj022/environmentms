<?php


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


//api
Route::get('/get_barcode/code/{code}/name/{name}', 'EPLPaymentController@generatePaymentBarCode');

//client file qr code
Route::get('qr_code', 'clientController@generateFileQrCode');
