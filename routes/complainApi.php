<?php

//use App\Http\Controllers\ResetSettingsController;

Route::middleware('auth:api')->group(function () {
    Route::post('save_complain', 'ComplainController@save_complain');
    Route::post('update_complain/id/{id}', 'ComplainController@update_complain');
    Route::post('delete_complain/id/{id}', 'ComplainController@delete_complain');
    Route::get('get_complain_data', 'ComplainController@show');
    Route::get('/complain_profile_data/id/{id}', 'ComplainController@complainProfileData');
    Route::post('/update_attachments/id/{id}', 'ComplainController@update_attachments');
    Route::get('/get_users_for_level/level/{level_id}', 'UserController@get_users_by_level');
    Route::get('/assign_complain_to_user/complain_id/{complain_id}/user_id/{user_id}', 'ComplainController@assign_complain_to_user');
    Route::post('/comment_on_complain', 'ComplainController@add_comment_to_complain');
    Route::post('/minute_on_complain', 'ComplainController@add_minute_to_complain');
    Route::get('/confirm_complain/complain/{complain_id}', 'ComplainController@confirm_complain');
    Route::get('/reject_complain/complain/{complain_id}', 'ComplainController@reject_complain');
    Route::get('/forward_to_letter_preforation/complain/{complain_id}', 'ComplainController@forward_to_letter_preforation');
    Route::get('/complain_log_data/complain/{complain_id}', 'ComplainController@get_complain_assign_log');
    Route::get('/forwarded_complains', 'ComplainController@forwarded_complains');
    Route::post('/delete_attach', 'ComplainController@removeAttach');
    Route::get('/load_file_no', 'ComplainController@loadFileNo');
    Route::post('/assign_file_no', 'ComplainController@assignFileNo');
});
