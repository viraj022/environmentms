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

Route::middleware('auth:api')->get('/search/client/type/{type}', 'SearchController@search'); // 

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