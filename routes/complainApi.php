<?php

//use App\Http\Controllers\ResetSettingsController;

Route::middleware('auth:api')->post('save_complain', 'ComplainController@save_complain');
Route::middleware('auth:api')->post('update_complain/id/{id}', 'ComplainController@update_complain');
Route::middleware('auth:api')->delete('delete_complain/id/{id}', 'ComplainController@delete_complain');
Route::get('/get_complain_data', 'ComplainController@show');
Route::get('/complain_profile_data/id/{id}', 'ComplainController@complainProfileData');
Route::middleware('auth:api')->post('/update_attachments/id/{id}', 'ComplainController@update_attachments');
