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
Route::middleware('auth:api')->post('/attachement','AttachemntsController@create'); //insert attachment
/*
{
	"name":"Hansana"
}*/

Route::middleware('auth:api')->get('/attachements','AttachemntsController@show'); //get all attachments
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

Route::middleware('auth:api')->get('/attachement/id/{id}','AttachemntsController@find'); //get a attachment by id
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


Route::middleware('auth:api')->put('/attachement/id/{id}','AttachemntsController@store'); //update attachment



Route::middleware('auth:api')->delete('/attachement/id/{id}','AttachemntsController@destroy'); //delete attachment

Route::middleware('auth:api')->get('/attachements/name/{name}','AttachemntsController@isNameUnique'); //check for unique name
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
Route::middleware('auth:api')->post('/industrycategory','IndustryCategoryController@create'); //insert Industry Category
/*
{
	"name":"Agriculture Farm",
	"code":"AG"
}*/


Route::middleware('auth:api')->get('/industrycategory/id/{id}','IndustryCategoryController@find'); //get a IndustryCategory by id
/*
[
    
]
*/

Route::middleware('auth:api')->get('/industrycategories','IndustryCategoryController@show'); //get all IndustryCategory
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

Route::middleware('auth:api')->delete('/industrycategory/id/{id}','IndustryCategoryController@destroy'); //delete IndustryCategory
Route::middleware('auth:api')->put('/industrycategory/id/{id}','IndustryCategoryController@store'); //update IndustryCategory

Route::middleware('auth:api')->get('/industrycategory/name/{name}','IndustryCategoryController@isNameUnique'); //check for unique name
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
Route::middleware('auth:api')->get('/industrycategory/code/{code}','IndustryCategoryController@isCodeUnique'); //check for unique Code
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
Route::middleware('auth:api')->post('/pradesheeyasaba','PradesheeyasabaController@create'); //insert  Pradesheeyasaba
/*
{
	"name":"Agriculture Farm",
	"code":"AG"
}*/


Route::middleware('auth:api')->get('/pradesheeyasaba/id/{id}','PradesheeyasabaController@find'); //get a Pradesheeyasaba by id
/*
[
    
]
*/

Route::middleware('auth:api')->get('/pradesheeyasabas','PradesheeyasabaController@show'); //get all Pradesheeyasaba
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

Route::middleware('auth:api')->delete('/pradesheeyasaba/id/{id}','PradesheeyasabaController@destroy'); //delete Pradesheeyasaba
Route::middleware('auth:api')->put('/pradesheeyasaba/id/{id}','PradesheeyasabaController@store'); //update Pradesheeyasaba

Route::middleware('auth:api')->get('/pradesheeyasaba/name/{name}','PradesheeyasabaController@isNameUnique'); //check for unique name
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
Route::middleware('auth:api')->get('/pradesheeyasaba/code/{code}','PradesheeyasabaController@isCodeUnique'); //check for unique Code
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

//end Pradesheeyasaba api


//payment type
Route::middleware('auth:api')->post('/payment_type','PaymentTypeController@create'); //insert  Payment type
/*
{
    "name": "card "
}

*/

Route::middleware('auth:api')->put('/payment_type/id/{id}','PaymentTypeController@store'); //update Payment type
/*
{
    "name": "cash "
}
*/


Route::middleware('auth:api')->get('/payment_type','PaymentTypeController@show'); //get all payment type

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

Route::middleware('auth:api')->get('/payment_type/id/{id}','PaymentTypeController@find'); //get a payment type by id
/*
{
    "id": 1,
    "name": "cash",
    "created_at": "2020-02-24 08:52:21",
    "updated_at": "2020-02-24 08:57:28"
}
*/


Route::middleware('auth:api')->delete('/payment_type/id/{id}','PaymentTypeController@destroy'); //delete payment type
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
}*/

/*
server response

{
    "id": 1,
    "message": "true"
}
*/
Route::middleware('auth:api')->put('/payment/id/{id}','PaymentsController@store'); //update Payment type
/*
{
    "name": "cash "
}
*/


Route::middleware('auth:api')->get('/payment','PaymentsController@show'); //get  all payment details with payment type name


//end payments codes