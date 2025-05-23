<?php
// Route::middleware('auth:api')->post('/site_clearance_new', 'SiteClearanceController@create'); // save site clearance

Route::middleware('auth:api')->get('/letter_template/id/{id}', 'WebDocumentController@GetLetterTemplateById'); //  get template by template id

Route::middleware('auth:api')->post('/save_warning_letter', 'WarningLetterController@store');
