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

Route::middleware('auth:api')->get('/get/id/{id}', 'CashierController@getDetailsByCode'); // get details to cashier
/*
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
    "application_client": {
        "id": 20,
        "name": "hansana",
        "nic": null,
        "address": null,
        "contact_no": null,
        "created_at": "2020-06-24 10:39:02",
        "updated_at": "2020-06-24 10:39:02"
    },
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
            "client_id": 20,
            "payment": {
                "id": 4,
                "payment_type_id": 3,
                "name": "EPL Application Fee",
                "type": "regular",
                "amount": "100.00",
                "created_at": "2020-03-13 10:10:45",
                "updated_at": "2020-03-13 10:10:45"
            }
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
            "client_id": 20,
            "payment": {
                "id": 3,
                "payment_type_id": 3,
                "name": "Telecommunication Tower Site Clearance Application Fee",
                "type": "regular",
                "amount": "100.00",
                "created_at": "2020-03-13 10:08:20",
                "updated_at": "2020-03-13 10:08:51"
            }
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
            "client_id": 20,
            "payment": {
                "id": 5,
                "payment_type_id": 3,
                "name": "EPL Renewal Application Fee",
                "type": "regular",
                "amount": "50.00",
                "created_at": "2020-03-13 10:11:38",
                "updated_at": "2020-03-13 10:12:12"
            }
        }
    ]
}
*/
Route::middleware('auth:api')->post('/pay/id/{id}', 'CashierController@pay'); // pat the payment
/*{

     'cashier_name' => 'required|string',
            'invoice_no' => ['required', 'string'],
}*/

/*
{
    "id": 1,
    "message": "true"
}
*/
Route::middleware('auth:api')->post('/cancel/invoice_no/{invoice_no}', 'CashierController@cancel'); // cancel a bill
/*
{
    "id": 1,
    "message": "true"
}
*/


