<?php
Route::middleware('auth:api')->post('/site_clearance_new', 'SiteClearanceController@create'); // save site clearance
Route::middleware('auth:api')->get('/site_clearance/{id}', 'SiteClearanceController@find'); //  get site clearance data