<?php

//use App\Http\Controllers\ResetSettingsController;

Route::middleware('auth:api')->post('save_complain', 'ComplainController@save_complain');
Route::middleware('auth:api')->post('update_complain/id/{id}', 'ComplainController@update_complain');
Route::middleware('auth:api')->delete('delete_complain/id/{id}', 'ComplainController@delete_complain');
Route::get('/get_complain_data', 'ComplainController@show');
Route::get('/complain_profile_data/id/{id}', 'ComplainController@complainProfileData');
Route::middleware('auth:api')->post('/update_attachments/id/{id}', 'ComplainController@update_attachments');
Route::middleware('auth:api')->get('/get_users_for_level/level/{level_id}', 'UserController@get_users_by_level');
Route::middleware('auth:api')->get('/assign_complain_to_user/complain_id/{complain_id}/user_id/{user_id}', 'ComplainController@assign_complain_to_user');
Route::middleware('auth:api')->post('/comment_on_complain', 'ComplainController@add_comment_to_complain');
Route::middleware('auth:api')->post('/minute_on_complain', 'ComplainController@add_minute_to_complain');
Route::middleware('auth:api')->get('/confirm_complain/complain/{complain_id}', 'ComplainController@confirm_complain');
Route::middleware('auth:api')->get('/reject_complain/complain/{complain_id}', 'ComplainController@reject_complain');
Route::middleware('auth:api')->get('/forward_to_letter_preforation/complain/{complain_id}', 'ComplainController@forward_to_letter_preforation');
Route::get('/complain_log_data/complain/{complain_id}', 'ComplainController@get_complain_assign_log');
Route::get('/forwarded_complains', 'ComplainController@forwarded_complains');
