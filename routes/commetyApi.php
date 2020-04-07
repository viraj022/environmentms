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

// drivers
Route::middleware('auth:api')->get('/committee', 'CommetyPoolController@show'); // get drivers in the la
/*
[
    {
        "id": 1,
        "first_name": "siyathu updated",
        "last_name": "banda",
        "nic": "950901390V",
        "address": "nakkawatta",
        "contact_no": "0710576923",
        "local_authority_id": 18,
        "created_at": "2020-04-05 13:26:19",
        "updated_at": "2020-04-05 13:44:33"
    }
]




*/


Route::middleware('auth:api')->post('/committee', 'CommetyPoolController@create'); //  insert driver
/*
{
	"first_name":"siyathu updated",
	"last_name":"banda",
	"address":"nakkawatta",
	"email":"email",
	"contact_no":"0710576923",
	"nic":"950901390V"
}
*/

Route::middleware('auth:api')->put('/committee/id/{id}', 'CommetyPoolController@store'); // update driver
/*
{
	"first_name":"siyathu updated",
	"last_name":"banda",
	"address":"nakkawatta",
	"contact_no":"0710576923",
	"nic":"950901390V"
}
*/

/// driver

Route::middleware('auth:api')->get('/committee/id/{id}', 'CommetyPoolController@find'); // get A driver

/*
{
    "id": 1,
    "first_name": "siyathu updated",
    "last_name": "banda",
    "nic": "950901390V",
    "address": "nakkawatta",
    "contact_no": "0710576923",
    "local_authority_id": 18,
    "created_at": "2020-04-05 13:26:19",
    "updated_at": "2020-04-05 13:44:33"
}
*/

Route::middleware('auth:api')->delete('/committee/id/{id}', 'CommetyPoolController@destroy'); // get A driver

/*
{
    "id": 1,
    "message": "true"
}

*/

Route::middleware('auth:api')->get('/committee/is_available/nic/{nic}', 'CommetyPoolController@uniqueNic'); // get A driver

/*
{
    "id": 1,
    "message": "true" true => if available false => is nic is already used
}
*/