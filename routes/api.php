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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

//api
Route::middleware('auth:api')->post('/rolls/rollId/{id}', 'RollController@store');
Route::middleware('auth:api')->delete('/rolls/rollId/{id}', 'RollController@destroy');
Route::middleware('auth:api')->get('/rolls/levelId/{id}', 'LevelController@rollsByLevel')->name('rolls_by_level');
Route::middleware('auth:api')->get('/rolls/rollPrivilege/{id}', 'RollController@getRollPrevilagesById')->name('Previlages_by_rollId');
Route::middleware('auth:api')->get('/user/Privileges/{id}', 'UserController@previlagesById');
Route::middleware('auth:api')->get('/rolls/privilege/add', 'RollController@PrevilagesAdd')->name('Previlages_add');
Route::middleware('auth:api')->get('/user/privilege/add/{id}', 'UserController@PrevilagesAddById');
Route::middleware('auth:api')->get('/user/activity/{id}', 'UserController@activeStatus');
Route::middleware('auth:api')->get('/level/institutes/id/{id}', 'LevelController@instituteById')->name('level_institues_by_id');

//attachment_api
Route::middleware('auth:api')->post('/attachement', 'AttachemntsController@create'); //insert attachment
/*
  {
  "name":"Hansana"
  } */

Route::middleware('auth:api')->get('/attachements', 'AttachemntsController@show'); //get all attachments
/*
  [
  {
  "id": 1,
  "name": "nadun",
  "created_at": "2020-02-13 07:12:27",
  "updated_at": "2020-02-13 07:12:27",
  "deleted_at": null
  },
  {
  "id": 2,
  "name": "Hansana",
  "created_at": "2020-02-13 07:14:12",
  "updated_at": "2020-02-13 07:14:12",
  "deleted_at": null
  }
  ]
 */

Route::middleware('auth:api')->get('/attachement/id/{id}', 'AttachemntsController@find'); //get a attachment by id
/*
  [
  {
  "id": 1,
  "name": "nadun",
  "created_at": "2020-02-13 07:12:27",
  "updated_at": "2020-02-13 07:12:27",
  "deleted_at": null
  },
  {
  "id": 2,
  "name": "Hansana",
  "created_at": "2020-02-13 07:14:12",
  "updated_at": "2020-02-13 07:14:12",
  "deleted_at": null
  }
  ]
 */


Route::middleware('auth:api')->put('/attachement/id/{id}', 'AttachemntsController@store'); //update attachment



Route::middleware('auth:api')->delete('/attachement/id/{id}', 'AttachemntsController@destroy'); //delete attachment

Route::middleware('auth:api')->get('/attachements/name/{name}', 'AttachemntsController@isNameUnique'); //check for unique name
/*
  value if name is  available

  {
  "id":1,
  "message":"unique"
  }

  value if name is not available
  {
  "id":1,
  "message":"notunique"

  }
 */

//end attachment_api
//IndustryCategory api
Route::middleware('auth:api')->post('/industrycategory', 'IndustryCategoryController@create'); //insert Industry Category
/*
  {
  "name":"Agriculture Farm",
  "code":"AG"
  } */


Route::middleware('auth:api')->get('/industrycategory/id/{id}', 'IndustryCategoryController@find'); //get a IndustryCategory by id
/*
  [

  ]
 */

Route::middleware('auth:api')->get('/industrycategories', 'IndustryCategoryController@show'); //get all IndustryCategory
/*
  [
  {
  "id": 1,
  "name": "Agriculture Farm",
  "code": "AG",
  "created_at": "2020-02-13 08:41:18",
  "updated_at": "2020-02-13 08:41:18"
  }
  ]
 */

Route::middleware('auth:api')->delete('/industrycategory/id/{id}', 'IndustryCategoryController@destroy'); //delete IndustryCategory
Route::middleware('auth:api')->put('/industrycategory/id/{id}', 'IndustryCategoryController@store'); //update IndustryCategory

Route::middleware('auth:api')->get('/industrycategory/name/{name}', 'IndustryCategoryController@isNameUnique'); //check for unique name
/*
  value if name is  available

  {
  "id":1,
  "message":"unique"
  }

  value if name is not available
  {
  "id":1,
  "message":"notunique"

  }
 */
Route::middleware('auth:api')->get('/industrycategory/code/{code}', 'IndustryCategoryController@isCodeUnique'); //check for unique Code
/*
  value if code is  available

  {
  "id":1,
  "message":"unique"
  }

  value if code is not available
  {
  "id":1,
  "message":"notunique"

  }
 */
//end IndustryCategory api
//Pradesheeyasaba api
Route::middleware('auth:api')->post('/pradesheeyasaba', 'PradesheeyasabaController@create'); //insert  Pradesheeyasaba
/*
  {
  "name":"Agriculture Farm",
  "code":"AG"
  } */


Route::middleware('auth:api')->get('/pradesheeyasaba/id/{id}', 'PradesheeyasabaController@find'); //get a Pradesheeyasaba by id
/*
  [

  ]
 */

Route::middleware('auth:api')->get('/pradesheeyasabas', 'PradesheeyasabaController@show'); //get all Pradesheeyasaba
/*
  [
  {
  "id": 1,
  "name": "Agriculture Farm",
  "code": "AG",
  "created_at": "2020-02-13 08:41:18",
  "updated_at": "2020-02-13 08:41:18"
  }
  ]
 */

Route::middleware('auth:api')->delete('/pradesheeyasaba/id/{id}', 'PradesheeyasabaController@destroy'); //delete Pradesheeyasaba
Route::middleware('auth:api')->put('/pradesheeyasaba/id/{id}', 'PradesheeyasabaController@store'); //update Pradesheeyasaba

Route::middleware('auth:api')->get('/pradesheeyasaba/name/{name}', 'PradesheeyasabaController@isNameUnique'); //check for unique name
/*
  value if name is  available

  {
  "id":1,
  "message":"unique"
  }

  value if name is not available
  {
  "id":1,
  "message":"notunique"

  }
 */
Route::middleware('auth:api')->get('/pradesheeyasaba/code/{code}', 'PradesheeyasabaController@isCodeUnique'); //check for unique Code
/*
  value if code is  available

  {
  "id":1,
  "message":"unique"
  }

  value if code is not available
  {
  "id":1,
  "message":"notunique"

  }
 */
Route::middleware('auth:api')->get('/pradesheeyasabas/zone/id/{id}', 'PradesheeyasabaController@getLocalAuthorityByZone'); //check for unique Code
/*
  [
  {
  "id": 17,
  "name": "Polpithigama Pradeshiya Sabha",
  "code": "PPP",
  "created_at": "2020-02-25 12:33:03",
  "updated_at": "2020-02-25 12:33:03",
  "zone_id": 2
  },
  {
  "id": 23,
  "name": "Giribawa Pradeshiya Sabha",
  "code": "PGB",
  "created_at": "2020-02-25 12:38:02",
  "updated_at": "2020-02-25 12:38:02",
  "zone_id": 2
  },
  {
  "id": 25,
  "name": "Udubaddawa Pradeshiya Sabha",
  "code": "PUB",
  "created_at": "2020-02-25 12:38:48",
  "updated_at": "2020-02-25 12:38:48",
  "zone_id": 2
  }
  ]
 */

//end Pradesheeyasaba api
//payment type
Route::middleware('auth:api')->post('/payment_type', 'PaymentTypeController@create'); //insert  Payment type
/*
  {
  "name": "card "
  }

 */

Route::middleware('auth:api')->put('/payment_type/id/{id}', 'PaymentTypeController@store'); //update Payment type
/*
  {
  "name": "cash "
  }
 */


Route::middleware('auth:api')->get('/payment_type', 'PaymentTypeController@show'); //get all payment type

/*
  [
  {
  "id": 1,
  "name": "cash",
  "created_at": "2020-02-24 08:52:21",
  "updated_at": "2020-02-24 08:57:28"
  }
  ]
 */

Route::middleware('auth:api')->get('/payment_type/id/{id}', 'PaymentTypeController@find'); //get a payment type by id
/*
  {
  "id": 1,
  "name": "cash",
  "created_at": "2020-02-24 08:52:21",
  "updated_at": "2020-02-24 08:57:28"
  }
 */


Route::middleware('auth:api')->delete('/payment_type/id/{id}', 'PaymentTypeController@destroy'); //delete payment type
/*
  {
  "id": 1,
  "message": "true"
  }
 */
// end payment type codes
//payments codes

Route::middleware('auth:api')->post('/payment', 'PaymentsController@create');
//data input example 
/*
  {
  "payment_type_id": "2",
  "name":"test",
  "type":"test",
  "amount":"25.30"
  } */

/*
  server response

  {
  "id": 1,
  "message": "true"
  }
 */
Route::middleware('auth:api')->put('/payment/id/{id}', 'PaymentsController@store'); //update Payment type
/*
  {
  "name": "cash "
  }
 */


Route::middleware('auth:api')->get('/payment', 'PaymentsController@show'); //get  all payment details with payment type name

Route::middleware('auth:api')->get('/payment/payment_type/id/{id}', 'PaymentsController@showByPaymentType'); //get  all payment details with payment type name


Route::middleware('auth:api')->delete('/payment/id/{id}', 'PaymentsController@destroy'); //deletePayment
/*
  {
  "id": 1,
  "message": "true"
  }
 */

Route::middleware('auth:api')->get('/payment/id/{id}', 'PaymentsController@findPayment'); //get a Payment by id

/*
  {
  "id": 13,
  "payment_type_id": 2,
  "name": "test update 3",
  "type": "ranged",
  "amount": null,
  "created_at": "2020-02-25 11:07:44",
  "updated_at": "2020-02-25 11:37:58"
  }

 */
//end payments codes
//ranged codes


Route::middleware('auth:api')->get('/rangedpayment', 'PaymentsController@findPayment_by_type'); //get a Payment  by type
/*
  [
  {
  "id": 13,
  "payment_type_id": 2,
  "name": "test",
  "type": "ranged",
  "amount": null,
  "created_at": "2020-02-25 11:07:44",
  "updated_at": "2020-02-26 06:38:03"
  },
  {
  "id": 16,
  "payment_type_id": 2,
  "name": "test",
  "type": "ranged",
  "amount": null,
  "created_at": "2020-02-26 05:39:25",
  "updated_at": "2020-02-26 05:39:25"
  }
  ]
 */
Route::middleware('auth:api')->post('/rangedpayment', 'PaymentsController@createRengedPayment'); //save payment range
/*
  {
  "payment_id": "13",
  "range": [
  {
  "from": "0",
  "to": "1000",
  "amount": "5000.00"
  },
  {
  "from": "0",
  "to": "1000",
  "amount": "6500.00"
  }
  ]
  }
 */
Route::middleware('auth:api')->delete('/rangedpayment/id/{id}', 'PaymentsController@destroyRangedPayment'); //deletePayment
/*
  {
  "id": 1,
  "message": "true"
  }
 */



Route::middleware('auth:api')->get('/findRangedPayment/payment_id/{payment_id}', 'PaymentsController@findRangedPayment'); //get a ranged Payment by payment_id

/*
  [
  {
  "id": 11,
  "payments_id": 11,
  "from": "0.00",
  "to": "1000.00",
  "amount": "9999999999.99",
  "created_at": "2020-02-26 09:53:41",
  "updated_at": "2020-02-26 09:53:41"
  },
  {
  "id": 12,
  "payments_id": 11,
  "from": "0.00",
  "to": "1000.00",
  "amount": "6500.00",
  "created_at": "2020-02-26 09:53:41",
  "updated_at": "2020-02-26 09:53:41"
  }
  ]
 */
//end ranged codes
//Zone API START
Route::middleware('auth:api')->post('/zone', 'ZoneController@create'); //Create 
Route::middleware('auth:api')->get('/zones', 'ZoneController@show'); //Get All Zones
Route::middleware('auth:api')->get('/zone/id/{id}', 'ZoneController@find'); //Get A Zone By ID
Route::middleware('auth:api')->put('/zone/id/{id}', 'ZoneController@store'); //Update Zone
Route::middleware('auth:api')->delete('/zone/id/{id}', 'ZoneController@destroy'); //Delete Zone
Route::middleware('auth:api')->get('/zone/name/{name}', 'ZoneController@isNameUnique'); //Check Unique Name
Route::middleware('auth:api')->get('/zone/code/{code}', 'ZoneController@isCodeUnique'); //Check Unique Code
//Zone API END
//AssistantDirector API
Route::middleware('auth:api')->get('/AssistantDirector/unassign', 'AssistantDirectorController@getAllUsersNotInAssistantDirector'); //get  all user not in assistant director table
/*
  [
  {
  "id": 2,
  "user_name": "envAdmin",
  "first_name": "Environment",
  "last_name": "Authority",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "roll_id": 1,
  "api_token": "M8gpFFS3nT5Ic6k0qQxvor073iott5dOouQ02Y4SIvQX444IQorQPnPYRoYh2zMQfEnRL8w8FWmwPNga",
  "institute_Id": null,
  "activeStatus": "Active",
  "created_at": "2020-02-19 15:20:10",
  "updated_at": "2020-02-19 15:20:10",
  "deleted_at": null
  },
  {
  "id": 3,
  "user_name": "ceytech",
  "first_name": "ceyTech",
  "last_name": "ceyTech",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "roll_id": 2,
  "api_token": "oAolH3Xf28TjtePyZ4D5RotH7NL1o6ov6PLLwrVFvmTHRU4QInvvq3Fsw24XjknEeGYoIIfvA2VIPDYU",
  "institute_Id": null,
  "activeStatus": "Active",
  "created_at": "2020-02-19 15:21:11",
  "updated_at": "2020-03-11 11:46:57",
  "deleted_at": null
  }

  ]

 */

Route::middleware('auth:api')->get('/AssistantDirector/active', 'AssistantDirectorController@getAll_active_AssistantDirector'); //get  all where activestatus =1  assistant director 
// [
// [
//     {
//         "first_name": "National",
//         "last_name": "National",
//         "user_name": "National",
//         "user_id": 1,
//         "zone_id": 1,
//         "zone_name": "zone 1"
//     },
//     {
//         "first_name": "Environment",
//         "last_name": "Authority",
//         "user_name": "envAdmin",
//         "user_id": 2,
//         "zone_id": 2,
//         "zone_name": "Zone 2"
//     }
// ]
// ]
Route::middleware('auth:api')->get('/AssistantDirector/active/zone/id/{id}', 'AssistantDirectorController@assistantDirectorByZone'); //get  all where activestatus =1 by zone id 
// [
// [
//     {
//         "first_name": "National",
//         "last_name": "National",
//         "user_name": "National",
//         "user_id": 1,
//         "zone_id": 1,
//         "zone_name": "zone 1"
//     },
//     {
//         "first_name": "Environment",
//         "last_name": "Authority",
//         "user_name": "envAdmin",
//         "user_id": 2,
//         "zone_id": 2,
//         "zone_name": "Zone 2"
//     }
// ]
// ]


Route::middleware('auth:api')->get('/get_a_AssistantDirector/id/{id}', 'AssistantDirectorController@get_a_AssistantDirector'); //get a  AssistantDirector
/*
  {
  "first_name": "National",
  "last_name": "National",
  "user_name": "National",
  "user_id": 1,
  "zone_id": 1,
  "zone_name": "zone 1",
  "active_status": 1
  }

 */
Route::middleware('auth:api')->post('/AssistantDirector', 'AssistantDirectorController@create'); //insert assistant_director
/*
  {
  "user_id":"1",
  "zone_id":"1"
  }

  server responce

  {
  "id": 1,
  "message": "true"
  }

 */


//  Route::middleware('auth:api')->put('/assistantdirector/id/{id}', 'AssistantDirectorController@store'); //update AssistantDirector  all details
// /*
// {
//     "user_id":"1",
//     "zone_id":"1"
// }
// server responce
// {
//     "id": 1,
//     "message": "true"
// }
// */

Route::middleware('auth:api')->delete('/unassistantdirector/id/{id}', 'AssistantDirectorController@destroy'); //delete AssistantDirector  
/*
  server responce

  {
  "id": 1,
  "message": "true"
  }

 */


//end AssistantDirector API
// Environment Officer

Route::middleware('auth:api')->get('/environment_officers/unassigned', 'EnvironmentOfficerController@show'); // get unassigned environment officers  
/*

  [
  {
  "id": 3,
  "user_name": "ceytech",
  "first_name": "ceyTech",
  "last_name": "ceyTech",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "roll_id": 2,
  "api_token": "oAolH3Xf28TjtePyZ4D5RotH7NL1o6ov6PLLwrVFvmTHRU4QInvvq3Fsw24XjknEeGYoIIfvA2VIPDYU",
  "institute_Id": null,
  "activeStatus": "Active",
  "created_at": "2020-02-19 15:21:11",
  "updated_at": "2020-03-11 11:46:57",
  "deleted_at": null
  },
  {
  "id": 5,
  "user_name": "Director_Lenaduwa",
  "first_name": "Saman",
  "last_name": "Lenaduwa",
  "address": null,
  "contact_no": "0773512435",
  "email": "sklenaduwa@gmail.com",
  "nic": null,
  "roll_id": 2,
  "api_token": "tOP3QU6ztCu8d4kSzuy6ta23SQuWJCbC4i3PSOQxpcorHZcTs3g1kNLNyvsyP69qe7CW43x70pJG2uQ8",
  "institute_Id": null,
  "activeStatus": "Active",
  "created_at": "2020-02-26 11:28:56",
  "updated_at": "2020-02-26 11:28:56",
  "deleted_at": null
  },
  ]
 */
Route::middleware('auth:api')->post('/environment_officer', 'EnvironmentOfficerController@create'); //insert environment officer  
/*
  ! input
  {
  "user_id" : "5",
  "assistantDirector_id" :  "1"
  }

  ! output
  {
  "id": 1,
  "message": "true"
  }
 */
Route::middleware('auth:api')->get('/environment_officer/id/{id}', 'EnvironmentOfficerController@getAEnvironmentOfficer'); //get an environment officer  
/*
  {
  "first_name": "Wasantha",
  "last_name": "Lansakara",
  "user_name": "AD_Wasantha",
  "user_id": 10,
  "active_status": 1,
  "zone_id": 1,
  "zone_name": "zone 1",
  "assistant_director_first_name": "National",
  "assistant_director_last_name": "National",
  "assistant_director_user_name": "National"
  }
 */
Route::middleware('auth:api')->get('/environment_officers/assistant_director/id/{id}', 'EnvironmentOfficerController@getAEnvironmentOfficerByAssitantDirector'); //get an environment officer by assistant director id  
/*
  [
  {
  "first_name": "Wasantha",
  "last_name": "Lansakara",
  "user_name": "AD_Wasantha",
  "user_id": 10,
  "active_status": 1,
  "zone_id": 1,
  "zone_name": "zone 1",
  "assistant_director_first_name": "National",
  "assistant_director_last_name": "National",
  "assistant_director_user_name": "National"
  }
  ]
 */

Route::middleware('auth:api')->delete('/environment_officers/id/{id}', 'EnvironmentOfficerController@destroy'); // ! delete an environment officer by id
/*
  ! output

  {
  "id": 1,
  "message": "true"
  }

 */

//end env officer api
//Client  api codes 

Route::middleware('auth:api')->post('/client', 'ClientController@create'); //save Client 

/* request Example 
  {
  "first_name" : "test fname",
  "last_name" : "test lname",
  "address" : "test address",
  "contact_no" : "0719546738",
  "email": "test@email.com",
  "nic" : "000000000V",
  "password" : "00000",
  } */


Route::middleware('auth:api')->get('/client', 'ClientController@show'); //get all Client 

/*
  response Example
  [
  {
  "id": 1,
  "first_name": "test fname",
  "last_name": "test lname",
  "address": "test address",
  "contact_no": "0719546738",
  "email": "test@email.com",
  "nic": "000000000V",
  "password": "00000",
  "api_token": null,
  "created_at": "2020-04-01 12:45:43",
  "updated_at": "2020-04-01 12:45:43",
  "deleted_at": null
  }
  ]

  validation response Example
 */

Route::middleware('auth:api')->get('/client/nic/{nic}', 'ClientController@findClient_by_nic'); //get a Client by nic  

/* response Example  
  //validation response Example
  [
  {
  "id": 2,
  "first_name": "Nadun",
  "last_name": "test lname",
  "address": "test address",
  "contact_no": "0719546738",
  "email": "test@email.com",
  "nic": "000000000V",
  "password": "00000",
  "api_token": null,
  "created_at": "2020-04-01 12:59:52",
  "updated_at": "2020-04-01 12:59:52",
  "deleted_at": null
  }
  ]
 */

Route::middleware('auth:api')->put('/client/id/{id}', 'ClientController@store'); //update Client 

/* request Example 
  {
  "first_name" : "Nadun",
  "last_name" : "test lname",
  "address" : "test address",
  "contact_no" : "0719546738",
  "email": "test@email.com",
  "nic" : "000000000V",
  "password" : "00000"
  }
  response Example
  validation response Example */

Route::middleware('auth:api')->delete('/client/id/{id}', 'ClientController@destroy'); //deleteClient
// {
//     "id": 1,
//     "message": "true"
// }
// 
// 

Route::middleware('auth:api')->get('/client/id/{id}', 'ClientController@findClient_by_id'); //get a Client by ID  

//end Client  api codes 


/// application attachment map
Route::middleware('auth:api')->get('/applicationTypes', 'ApplicationTypeController@show'); // Get Application types with their attachemnts


/*
[
    {
        "id": 1,
        "name": "Environment Protection Licence",
        "created_at": "2020-04-02 11:32:10",
        "updated_at": "2020-04-02 11:32:10",
        "attachemnts": []
    },
    {
        "id": 2,
        "name": "Site Clearance Licence",
        "created_at": "2020-04-02 11:32:10",
        "updated_at": "2020-04-02 11:32:10",
        "attachemnts": [
            {
                "id": 1,
                "name": "Copy of deed, copy of the Lease agreement of the land -Legal authorization to use the land for the particular industrial activity",
                "created_at": "2020-02-26 11:04:17",
                "updated_at": "2020-02-26 11:04:31",
                "deleted_at": null,
                "pivot": {
                    "application_type_id": 2,
                    "attachemnt_id": 1
                }
            },
 ]           

*/

Route::middleware('auth:api')->get('/applicationTypes/id/{id}', 'ApplicationTypeController@find'); // Get Application types by id


/*
{
    "id": 2,
    "name": "Site Clearance Licence",
    "created_at": "2020-04-02 11:32:10",
    "updated_at": "2020-04-02 11:32:10",
    "attachemnts": [
        {
            "id": 1,
            "name": "Copy of deed, copy of the Lease agreement of the land -Legal authorization to use the land for the particular industrial activity",
            "created_at": "2020-02-26 11:04:17",
            "updated_at": "2020-02-26 11:04:31",
            "deleted_at": null,
            "pivot": {
                "application_type_id": 2,
                "attachemnt_id": 1
            }
        },
        {
            "id": 1,
            "name": "Copy of deed, copy of the Lease agreement of the land -Legal authorization to use the land for the particular industrial activity",
            "created_at": "2020-02-26 11:04:17",
            "updated_at": "2020-02-26 11:04:31",
            "deleted_at": null,
            "pivot": {
                "application_type_id": 2,
                "attachemnt_id": 1
            }
        }
        ]
    }
    
    */
Route::middleware('auth:api')->post('/applicationType', 'ApplicationTypeController@create'); //   save attachements to a application

/*
    {
        "id": "1",
        "attachment": [  
     * 1,
     * 2    
        ]
    }
    */
Route::middleware('auth:api')->get('/applicationType/available/id/{id}', 'ApplicationTypeController@availableAttachements'); // Get available (not assigned) attachments by application id

/*

[
    {
        "id": 3,
        "name": "Business Registration Certificate / Copy of the  National Identity Card of the  Industry Owner",
        "created_at": "2020-02-26 11:06:12",
        "updated_at": "2020-02-28 09:24:41",
        "deleted_at": null
    },
    {
        "id": 4,
        "name": "Clear route map to approach the proposed site or industry",
        "created_at": "2020-02-26 11:11:13",
        "updated_at": "2020-02-28 09:24:59",
        "deleted_at": null
    },
]
*/

Route::middleware('auth:api')->get('/applicationType/assigned/id/{id}', 'ApplicationTypeController@assignedAttachements'); // Get assigned  attachments by applicatin id

/*

[
    {
        "id": 3,
        "name": "Business Registration Certificate / Copy of the  National Identity Card of the  Industry Owner",
        "created_at": "2020-02-26 11:06:12",
        "updated_at": "2020-02-28 09:24:41",
        "deleted_at": null
    },
    {
        "id": 4,
        "name": "Clear route map to approach the proposed site or industry",
        "created_at": "2020-02-26 11:11:13",
        "updated_at": "2020-02-28 09:24:59",
        "deleted_at": null
    },
]
*/

/// application attachment map
Route::middleware('auth:api')->get('/applicationType/allAtachmentWithStatus/id/{id}', 'ApplicationTypeController@allAttachmentsWithStatus'); // Get all attachment and assign attachments

/*

[
    {
        "id": 3,
        "name": "Business Registration Certificate / Copy of the  National Identity Card of the  Industry Owner",
        "created_at": "2020-02-26 11:06:12",
        "updated_at": "2020-02-28 09:24:41",
        "deleted_at": null
    },
    {
        "id": 4,
        "name": "Clear route map to approach the proposed site or industry",
        "created_at": "2020-02-26 11:11:13",
        "updated_at": "2020-02-28 09:24:59",
        "deleted_at": null
    },
]
*/

/// application attachment map

/// industry scale
Route::middleware('auth:api')->get('/business_scale', 'BusinessScaleController@show'); // 
Route::middleware('auth:api')->get('/files/client/id/{id}', 'EPLController@getDeadList'); // 

Route::middleware('auth:api')->get('/epl/certificate_information/id/{id}', 'EPLController@certificateInformation'); // 

/*

[
    {
        "id": 1,
        "name": "Large",
        "code": "L",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 2,
        "name": "Medium",
        "code": "M",
        "created_at": null,
        "updated_at": null
    },
    {
        "id": 3,
        "name": "Large",
        "code": "L",
        "created_at": null,
        "updated_at": null
    },

]
*/

/// application attachment map


Route::middleware('auth:api')->get('/payment/pending', 'CashierController@getPendingPaymentList'); // get app pending payment sessions
/*
{
    "id": 1,
    "message": "true"
}
*/

