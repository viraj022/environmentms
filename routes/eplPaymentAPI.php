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
Route::middleware('auth:api')->post('/epl/regPayment/id/{id}', 'EPLPaymentController@deleteApplicationPayment'); // save a registration  payment
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
Route::middleware('auth:api')->get('/application/fine_list', 'EPLPaymentController@getFineList'); // get application List
/*

 */
Route::middleware('auth:api')->get('/application/licenceList', 'EPLPaymentController@getLicenctList'); // get licence payment list
/*
  [
  {
  "id": 6,
  "payment_type_id": 5,
  "name": "Licence fee for industries category A",
  "type": "regular",
  "amount": "7500.00",
  "created_at": "2020-03-13 11:19:44",
  "updated_at": "2020-03-13 11:19:44",
  "payment_ranges": []
  },
  {
  "id": 7,
  "payment_type_id": 5,
  "name": "Licence fee for industries category B",
  "type": "regular",
  "amount": "2000.00",
  "created_at": "2020-03-13 11:19:58",
  "updated_at": "2020-03-13 11:19:58",
  "payment_ranges": []
  },
  {
  "id": 8,
  "payment_type_id": 5,
  "name": "Licence fee for industries category C",
  "type": "regular",
  "amount": "1200.00",
  "created_at": "2020-03-13 11:22:02",
  "updated_at": "2020-03-16 20:25:04",
  "payment_ranges": []
  }
  ]
 */


Route::middleware('auth:api')->get('/inspection/list', 'EPLPaymentController@getInspectionPaymentList'); // get inspection payment list

/*
  [
  {
  "id": 18,
  "payment_type_id": 4,
  "name": "Based on Initial Investment",
  "type": "ranged",
  "amount": null,
  "created_at": "2020-03-13 12:58:08",
  "updated_at": "2020-03-13 12:58:08",
  "payment_ranges": [
  {
  "id": 13,
  "payments_id": 18,
  "from": "100000.00",
  "to": "100000.00",
  "amount": "2000.00",
  "created_at": "2020-03-13 15:31:14",
  "updated_at": "2020-03-13 15:31:14"
  },
  {
  "id": 14,
  "payments_id": 18,
  "from": "100001.00",
  "to": "200000.00",
  "amount": "3000.00",
  "created_at": "2020-03-13 15:31:14",
  "updated_at": "2020-03-13 15:31:14"
  },
  {
  "id": 15,
  "payments_id": 18,
  "from": "200001.00",
  "to": "500000.00",
  "amount": "5000.00",
  "created_at": "2020-03-13 15:31:14",
  "updated_at": "2020-03-13 15:31:14"
  },
  {
  "id": 16,
  "payments_id": 18,
  "from": "500001.00",
  "to": "1000000.00",
  "amount": "7000.00",
  "created_at": "2020-03-13 15:31:14",
  "updated_at": "2020-03-13 15:31:14"
  }
  ]
  },
  {
  "id": 19,
  "payment_type_id": 4,
  "name": "Metal Quarry Artisan",
  "type": "regular",
  "amount": "1000.00",
  "created_at": "2020-03-13 15:41:48",
  "updated_at": "2020-03-13 15:41:48",
  "payment_ranges": []
  },
  ]
 */

Route::middleware('auth:api')->post('/application/markPayment/id/{id}', 'EPLPaymentController@markApplicationPayment'); // mark payment

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
Route::middleware('auth:api')->post('/application/process/id/{id}', 'EPLPaymentController@processApplication'); // process application

/*
  {
  "id": 1,
  "message": "true"
  }
 */

Route::middleware('auth:api')->post('/epl/pay/id/{id}', 'EPLPaymentController@payEPL'); //pay epl
/*

  {
  "items": [
  {
  "id": "19",
  "amount" : "450"
  }
  ]
  }

 */
/*
  {
  "id": 1,
  "message": "true",
  "code": 41
  }
 */
Route::middleware('auth:api')->get('/epl/pay/id/{id}', 'EPLPaymentController@paymentList'); // get payment list

/*
{
  "inspection": {
    "status": "payed",
    "object": {
      "id": 33,
      "transaction_id": 46,
      "qty": 1,
      "amount": 450,
      "payment_type_id": 4,
      "payment_id": 19,
      "created_at": "2020-06-29 15:59:44",
      "updated_at": "2020-06-29 15:59:44",
      "transaction_type": "EPL",
      "client_id": 9,
      "transaction": {
        "id": 46,
        "status": 0,
        "created_at": "2020-06-29 15:59:44",
        "updated_at": "2020-06-29 15:59:44",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "EPL",
        "type_id": 9
      }
    }
  },
  "license_fee": {
    "status": "payed",
    "object": {
      "id": 31,
      "transaction_id": 44,
      "qty": 1,
      "amount": 450,
      "payment_type_id": 5,
      "payment_id": 6,
      "created_at": "2020-06-29 11:03:47",
      "updated_at": "2020-06-29 11:03:47",
      "transaction_type": "EPL",
      "client_id": 9,
      "transaction": {
        "id": 44,
        "status": 0,
        "created_at": "2020-06-29 11:03:47",
        "updated_at": "2020-06-29 11:03:47",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "EPL",
        "type_id": 9
      }
    }
  },
  "fine": {
    "status": "payed", // not_payed // not_available
    "object": {
      "id": 32,
      "transaction_id": 45,
      "qty": 1,
      "amount": 450,
      "payment_type_id": 8,
      "payment_id": 74,
      "created_at": "2020-06-29 15:51:17",
      "updated_at": "2020-06-29 15:51:17",
      "transaction_type": "EPL",
      "client_id": 9,
      "transaction": {
        "id": 45,
        "status": 0,
        "created_at": "2020-06-29 15:51:17",
        "updated_at": "2020-06-29 15:51:17",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "EPL",
        "type_id": 9
      }
    }
  }
}
*/

Route::middleware('auth:api')->post('/get/epl/inspection/fine/id/{id}', 'EPLPaymentController@getInspectionFine'); // get inspection fine amount

/*
* input
{
  "inspection_fee" : 700000
}

*/

/*
* output
* case 1 // have a fine
{
  "id": 1,
  "message": "fine",
  "amount": 114500
}

*case 2 no fine
{
  "id": 1,
  "message": "no_fine",
  "amount": "0"
}


*/
Route::middleware('auth:api')->get('/siteClearance/pay/id/{id}', 'EPLPaymentController@SiteClearancePaymentList'); // get site clearance payment list

/**
 * not payed structure
 * {
 "inspection": {
   "status": "not_payed"
  },
  "license_fee": {
    "status": "not_payed"
  },
  "processing_fee": {
    "processing_fee_type": "IEE",
    "status": "not_payed"
  }
}

 */
/**
 *  payed structure
 * {
 "inspection": {
   "status": "payed",
   "object": {
     "id": 32,
     "transaction_id": 45,
     "qty": 1,
     "amount": 450,
     "payment_type_id": 8,
     "payment_id": 74,
     "created_at": "2020-06-29 15:51:17",
     "updated_at": "2020-06-29 15:51:17",
     "transaction_type": "EPL",
     "client_id": 9,
     "transaction": {
       "id": 45,
       "status": 0,
       "created_at": "2020-06-29 15:51:17",
       "updated_at": "2020-06-29 15:51:17",
       "deleted_at": null,
       "cashier_name": null,
       "invoice_no": null,
       "canceled_at": null,
       "billed_at": null,
       "type": "EPL",
       "type_id": 9
      }
    }
  },
  "license_fee": {
    "status": "not_payed",
    "object": {
      "id": 32,
      "transaction_id": 45,
      "qty": 1,
      "amount": 450,
      "payment_type_id": 8,
      "payment_id": 74,
      "created_at": "2020-06-29 15:51:17",
      "updated_at": "2020-06-29 15:51:17",
      "transaction_type": "EPL",
      "client_id": 9,
      "transaction": {
        "id": 45,
        "status": 0,
        "created_at": "2020-06-29 15:51:17",
        "updated_at": "2020-06-29 15:51:17",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "EPL",
        "type_id": 9
      }
    }
  },
  "processing_fee": {
    "processing_fee_type": "IEE",
    "status": "not_payed",
    "object": {
      "id": 32,
      "transaction_id": 45,
      "qty": 1,
      "amount": 450,
      "payment_type_id": 8,
      "payment_id": 74,
      "created_at": "2020-06-29 15:51:17",
      "updated_at": "2020-06-29 15:51:17",
      "transaction_type": "EPL",
      "client_id": 9,
      "transaction": {
        "id": 45,
        "status": 0,
        "created_at": "2020-06-29 15:51:17",
        "updated_at": "2020-06-29 15:51:17",
        "deleted_at": null,
        "cashier_name": null,
        "invoice_no": null,
        "canceled_at": null,
        "billed_at": null,
        "type": "EPL",
        "type_id": 9
      }
    }
  }
}

 */

Route::middleware('auth:api')->post('/siteClearance/pay/id/{id}', 'EPLPaymentController@paySiteClearance'); //site clearance pay
/*

  {
  "items": [
  {
  "id": "19",
  "amount" : "450"
  }
  ]
  }

 */
/*
  {
  "id": 1,
  "message": "true",
  "code": 41
  }
 */
Route::middleware('auth:api')->get('/processing_list', 'EPLPaymentController@getProcessingFeeList'); //get processing payment list
/**
 * {
    "EIA": [
        {
            "id": 71,
            "payment_type_id": 6,
            "name": "EIA Processing Fee",
            "type": "regular",
            "amount": "500000.00",
            "created_at": "2020-03-18 14:49:05",
            "updated_at": "2020-03-18 14:49:05",
            "payment_ranges": []
        }
    ],
    "IEE": [
        {
            "id": 72,
            "payment_type_id": 7,
            "name": "IEE Processing Fee",
            "type": "regular",
            "amount": "200000.00",
            "created_at": "2020-03-18 14:49:44",
            "updated_at": "2020-03-18 14:49:44",
            "payment_ranges": []
        }
    ]
}
 */
