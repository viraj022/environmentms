<?php
Route::middleware('auth:api')->post('/site_clearance_new', 'SiteClearanceController@create'); // 