<?php

use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });
//api


// sanctum routes

# login
Route::post('mobile-auth/login', 'MobileAuthController@login')->name('mobile-app.login');

// /api/mobile-auth/login
Route::prefix('mobile-auth')->middleware('auth:sanctum')->group(function () {
    # get current logged in user
    Route::get('user', 'MobileAuthController@user')->name('mobile-app.user');
    # logout
    Route::post('logout', 'MobileAuthController@logout')->name('mobile-app.logout');
});
Route::prefix('mobile')->middleware('auth:sanctum')->group(function () {
    Route::get('test', 'MobileController@test');
    Route::get('all_inspection_list', 'MobileController@inspectionFiles');
    Route::get('inspection_list/id/{id}', 'MobileController@inspectionFilesById');
    Route::post('images/{id}', 'MobileController@uploadImage');
    Route::get('eo_inspections/{id}', 'MobileController@inspectionListForEo');
    Route::get('users_list', 'MobileController@usersList');
    Route::post('upload_mobile_inspection', 'MobileController@updateMobileInspection');
});
