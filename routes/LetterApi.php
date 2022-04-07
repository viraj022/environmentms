<?php
// Route::middleware('auth:api')->post('/site_clearance_new', 'SiteClearanceController@create'); // save site clearance
// Route::middleware('auth:api')->patch('/site_clearance/processing_status/{siteClearanceSession}', 'SiteClearanceController@setProcessingStatus'); //  set site clearance processing status

Route::middleware('auth:api')->get('/letter_template/id/{id}', 'WebDocumentController@GetLetterTemplateById'); //  get template by template id

Route::middleware('auth:api')->post('/save_warning_letter', 'WarningLetterController@store');
