<?php

Route::middleware('auth:api')->post('/save_document', 'WebDocumentController@save_letter_content');
Route::middleware('auth:api')->get('/get_all_letters', 'WebDocumentController@get_all_letters');
Route::middleware('auth:api')->post('/update_document', 'WebDocumentController@update_letter_content');
Route::middleware('auth:api')->post('/letter_status_change/status/{status}/letter/{letter_id}', 'WebDocumentController@letter_status_change');
Route::middleware('auth:api')->post('/create_let_template', 'WebDocumentController@createLetterTemplate');
Route::middleware('auth:api')->post('/update_let_template', 'WebDocumentController@updateLetterTemplate');
Route::middleware('auth:api')->get('/load_templates', 'WebDocumentController@loadTemplates');


