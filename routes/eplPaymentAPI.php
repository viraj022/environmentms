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

Route::middleware('auth:api')->post('/epl/regPayment', 'EPLPaymentController@addRegistrationPayment'); // save a registration  payment
/*
{
   "name":"hansana",
   "amount":750
}
*/

/*
{
    "id": 1,
    "message": "true",
    "code": 3
}
*/


Route::middleware('auth:api')->get('/application/pendingPayments', 'EPLPaymentController@getPendingApplicationList'); // get pending appication list

/*
[
    {
        "id": 2,
        "name": "hansana",
        "nic": null,
        "address": null,
        "contact_no": null,
        "created_at": "2020-06-22 05:24:16",
        "updated_at": "2020-06-22 05:24:16",
        "counter_id": 1
    }
]
*/
Route::middleware('auth:api')->get('/application/applicationList', 'EPLPaymentController@getApplicationList'); // get application List

/*
[
    {
        "id": 2,
        "name": "hansana",
        "nic": null,
        "address": null,
        "contact_no": null,
        "created_at": "2020-06-22 05:24:16",
        "updated_at": "2020-06-22 05:24:16",
        "counter_id": 1
    }
]
*/

Route::middleware('auth:api')->patch('/application/markPayment/id/{id}', 'EPLPaymentController@markApplicationPayment'); // mark payment

/*
[
    {
        "id": 2,
        "name": "hansana",
        "nic": null,
        "address": null,
        "contact_no": null,
        "created_at": "2020-06-22 05:24:16",
        "updated_at": "2020-06-22 05:24:16",
        "counter_id": 1
    }
]
*/
