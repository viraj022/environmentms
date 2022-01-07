<?php

use App\Http\Controllers\ComplainController;
//use App\Http\Controllers\ResetSettingsController;
Route::middleware('auth:api')->post('save_complain', [ComplainController::class, 'save_complain']);
Route::middleware('auth:api')->put('/udpate_complain/id/{id}', [ComplainController::class, 'update_complain']);
Route::middleware('auth:api')->delete('/delete_complain/id/{id}', [ComplainController::class, 'delete_complain']);
Route::get('/get_complain_data', [ComplainController::class, 'show']);
Route::get('/complain_profile_data/id/{id}', [ComplainController::class, 'complainProfileData']);
