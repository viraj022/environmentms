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
   "name": "hansana",
   "items": [
      {
         "id": 4,
         "qty": "5"
      },
      {
         "id": 3,
         "qty": "5"
      },
      {
         "id": 5,
         "qty": "5"
      }
   ]
}

/*
{
    "id": 1,
    "message": "true",
    "code": 3
}
*/
Route::middleware('auth:api')->delete('/epl/regPayment/id/{id}', 'EPLPaymentController@deleteApplicationPayment'); // save a registration  payment
/*
{
   "name": "hansana",
   "items": [
      {
         "id": 4,
         "qty": "5"
      },
      {
         "id": 3,
         "qty": "5"
      },
      {
         "id": 5,
         "qty": "5"
      }
   ]
}

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
        "id": 16,
        "status": 0,
        "created_at": "2020-06-24 10:39:01",
        "updated_at": "2020-06-24 10:39:01",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "application_fee",
        "type_id": 19,
        "transaction_items": [
            {
                "id": 5,
                "transaction_id": 16,
                "qty": 5,
                "amount": 100,
                "payment_type_id": 3,
                "payment_id": 4,
                "created_at": "2020-06-24 10:39:01",
                "updated_at": "2020-06-24 10:39:01",
                "transaction_type": "application_fee",
                "client_id": 19
            },
            {
                "id": 6,
                "transaction_id": 16,
                "qty": 5,
                "amount": 100,
                "payment_type_id": 3,
                "payment_id": 3,
                "created_at": "2020-06-24 10:39:01",
                "updated_at": "2020-06-24 10:39:01",
                "transaction_type": "application_fee",
                "client_id": 19
            },
            {
                "id": 7,
                "transaction_id": 16,
                "qty": 5,
                "amount": 50,
                "payment_type_id": 3,
                "payment_id": 5,
                "created_at": "2020-06-24 10:39:01",
                "updated_at": "2020-06-24 10:39:01",
                "transaction_type": "application_fee",
                "client_id": 19
            }
        ],
        "application_client": {
            "id": 19,
            "name": "hansana",
            "nic": null,
            "address": null,
            "contact_no": null,
            "created_at": "2020-06-24 10:39:01",
            "updated_at": "2020-06-24 10:39:01"
        }
    },
    {
        "id": 17,
        "status": 0,
        "created_at": "2020-06-24 10:39:02",
        "updated_at": "2020-06-24 10:39:02",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "application_fee",
        "type_id": 20,
        "transaction_items": [
            {
                "id": 8,
                "transaction_id": 17,
                "qty": 5,
                "amount": 100,
                "payment_type_id": 3,
                "payment_id": 4,
                "created_at": "2020-06-24 10:39:02",
                "updated_at": "2020-06-24 10:39:02",
                "transaction_type": "application_fee",
                "client_id": 20
            },
            {
                "id": 9,
                "transaction_id": 17,
                "qty": 5,
                "amount": 100,
                "payment_type_id": 3,
                "payment_id": 3,
                "created_at": "2020-06-24 10:39:02",
                "updated_at": "2020-06-24 10:39:02",
                "transaction_type": "application_fee",
                "client_id": 20
            },
            {
                "id": 10,
                "transaction_id": 17,
                "qty": 5,
                "amount": 50,
                "payment_type_id": 3,
                "payment_id": 5,
                "created_at": "2020-06-24 10:39:02",
                "updated_at": "2020-06-24 10:39:02",
                "transaction_type": "application_fee",
                "client_id": 20
            }
        ],
        "application_client": {
            "id": 20,
            "name": "hansana",
            "nic": null,
            "address": null,
            "contact_no": null,
            "created_at": "2020-06-24 10:39:02",
            "updated_at": "2020-06-24 10:39:02"
        }
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
Route::middleware('auth:api')->patch('/application/process/id/{id}', 'EPLPaymentController@processApplication'); // process application

/*

{
    "id": 1,
    "message": "true"
}
*/
