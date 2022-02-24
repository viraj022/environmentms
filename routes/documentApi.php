<?php

Route::middleware('auth:api')->post('/save_document', 'WebDocumentController@save_letter_content');
Route::middleware('auth:api')->get('/get_all_letters', 'WebDocumentController@get_all_letters');
Route::middleware('auth:api')->post('/update_document', 'WebDocumentController@update_letter_content');
