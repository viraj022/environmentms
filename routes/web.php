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

//ui routs

//dashboard
Route::get('/dashboard', function () {
    return view('welcome');
});
//dashboard
