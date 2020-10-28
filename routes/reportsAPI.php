<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/file_log/{file_id}', 'ReportController@getFileLog'); // 

/*
{
    "value":"xcvxc"
}
types
* name  // like function show clients (multiple)
* id  (single)
* epl  (single)
* license  (single)
* business_reg  (single)
* business_name like function show business (multiple)

*/

// Route::middleware('auth:api')->get('/testReport', 'ReportController@siteClearanceApplicationReport');

/**
 * Dashboard
 * request format
 * 
 {
    "renew_chart": {
        "from": "2020-01-01",
        "to": "2020-12-31"
    },
    "new_file_chart": {
        "from": "2020-01-01",
        "to": "2020-12-31"
    },
    "file_category_chart": {
        "from": "2020-01-01",
        "to": "2020-12-31"
    },
    "new_job_chart": {
        "from": "2020-01-01",
        "to": "2020-12-31"
    },
    "pra_table": {
        "from": "2020-01-01",
        "to": "2020-12-31"
    },
    "env_officer_table": {},
    "industry_category_table": {},
    "file_status_lable": {}
}
 *response format
 * just run the code and find it out
 */

Route::middleware('auth:api')->get('/dashboard', 'DashboardController@getDashboardData');
