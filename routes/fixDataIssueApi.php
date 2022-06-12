<?php


/**
 * APis for fix site clearance data issue
 */


Route::get('/fix_issue_date', 'SiteClearanceFixController@fixIssueDate');
Route::get('/fix_session_issue_date', 'SiteClearanceFixController@fixSessionIssueDate');
