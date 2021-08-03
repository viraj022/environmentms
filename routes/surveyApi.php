<?php

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

/*
 * survey title
 */

Route::middleware('auth:api')->get('/survey/titles', 'SurveyTitleController@index'); // get all survey titles
Route::middleware('auth:api')->get('/survey/title/id/{id}', 'SurveyTitleController@find'); // get a survey title by id
Route::middleware('auth:api')->get('/survey/title/attributes/id/{id}', 'SurveyTitleController@attributes'); // get attributes of a given title id
Route::middleware('auth:api')->post('/survey/title', 'SurveyTitleController@create'); // create a survey title
Route::middleware('auth:api')->put('/survey/title/id/{id}', 'SurveyTitleController@update'); // update a survey title
Route::middleware('auth:api')->delete('/survey/title/id/{id}', 'SurveyTitleController@delete'); // delete a survey title by id
Route::middleware('auth:api')->post('/survey/order', 'SurveyTitleController@updateOrder'); // update order
//  format  {"survey_title_name":"tikiri mole", "survey_title_status":1}
//format for order change
// {
//     "order": [
//         {
//             "titleID": "1",
//             "order": "1"
//         },
//         {
//             "titleID": "2",
//             "order": "2"
//         }

//     ]
// }

/*
 * survey title end
 */

/*
 * survey attribute
 */
Route::middleware('auth:api')->post('/survey/attribute', 'SurveyAttributeController@create'); // create survey attribute
Route::middleware('auth:api')->get('/survey/attributes', 'SurveyAttributeController@all'); // get all survey attributes
Route::middleware('auth:api')->get('/survey/attribute/id/{id}', 'SurveyAttributeController@find'); // get a survey atttribute
Route::middleware('auth:api')->put('/survey/attribute/id/{id}', 'SurveyAttributeController@update'); // update
Route::middleware('auth:api')->delete('/survey/attribute/id/{id}', 'SurveyAttributeController@delete'); // delete
Route::middleware('auth:api')->get('/survey/attribute/title/id/{id}', 'SurveyAttributeController@title'); // get attributes by title
// Route::middleware('auth:api')->get('/survey/attribute/title/id/{id}', 'SurveyAttributeController@title'); // get attributes by title
Route::middleware('auth:api')->post('/survey/attribute/order', 'SurveyAttributeController@updateOrder'); // update order

//{
//    "survey_attribute_name": "tikiri moleeee",
//    "survey_title_id":"3"
//}

//format for order change
// {
//     "order": [
//         {
//             "attributeID": "1",
//             "order": "1"
//         },
//         {
//             "attributeID": "2",
//             "order": "2"
//         }

//     ]
// }

/*
 * survey attribute end
 */

/*
 * survey value
 */

Route::middleware('auth:api')->post('/survey/value', 'SurveyValueController@create'); // create
Route::middleware('auth:api')->get('/survey/values/id/{id}', 'SurveyValueController@all'); // get all values my map id
Route::middleware('auth:api')->get('/survey/value/id/{id}', 'SurveyValueController@find'); // get one
Route::middleware('auth:api')->put('/survey/value/id/{id}', 'SurveyValueController@update'); // update
Route::middleware('auth:api')->delete('/survey/value/id/{id}', 'SurveyValueController@delete'); // delete

// {
//     "survey_value_name":"h1",
//     "suray_param_attributes_id":"3"

// }

/*
 * survey value end
 */

/*
 * survey Parameter
 */

Route::middleware('auth:api')->post('/survey/parameter', 'ParameterController@create'); // create
Route::middleware('auth:api')->get('/survey/parameter', 'ParameterController@all'); // get all
Route::middleware('auth:api')->get('/survey/parameter/assigned/title_id/{titleId}/attribute_id/{attributeID}', 'ParameterController@assignedParameters'); // get assigned parameters for a given title id and attribute id
Route::middleware('auth:api')->get('/survey/parameter/assignedrow/title_id/{titleId}/attribute_id/{attributeID}', 'ParameterController@assignedParametersrow'); // get assigned parameters for a given title id and attribute id
Route::middleware('auth:api')->get('/survey/parameter/unassigned/title_id/{titleId}/attribute_id/{attributeID}', 'ParameterController@doesntAssignedParameters'); // get gitassigned parameters for a given title id and attribute id
Route::middleware('auth:api')->get('/survey/parameter/id/{id}', 'ParameterController@find'); // get one
Route::middleware('auth:api')->put('/survey/parameter/id/{id}', 'ParameterController@update'); // update
Route::middleware('auth:api')->delete('/survey/parameter/id/{id}', 'ParameterController@delete'); // delete
Route::middleware('auth:api')->get('/survey/parameter/title/id/{id}', 'ParameterController@title'); // get parameter by title

//{
//    "survey_parameter_name": "tikiri moleeeedddd",
//    "survey_title_id": "1"
//
//}

/*
 * survey Parameter atribute map
 */

Route::middleware('auth:api')->post('/survey/attrpram_map', 'SurayParamAttributeController@create'); // create
Route::middleware('auth:api')->get('/survey/attrpram_map', 'SurayParamAttributeController@all'); // get all
Route::middleware('auth:api')->get('/survey/attrpram_map/id/{id}', 'SurayParamAttributeController@find'); // get one
Route::middleware('auth:api')->get('/survey/attrpram_map/parameter_id/{parameter_id}/survey_attribute_id/{survey_attribute_id}', 'SurayParamAttributeController@ids'); // get one
Route::middleware('auth:api')->put('/survey/attrpram_map/id/{id}', 'SurayParamAttributeController@update'); // update
Route::middleware('auth:api')->delete('/survey/attrpram_map/id/{id}', 'SurayParamAttributeController@delete'); // delete
Route::middleware('auth:api')->get('/survey/attrpram_map/title/id/{id}', 'SurayParamAttributeController@title'); // get parameter by title
Route::middleware('auth:api')->get('/survey/attrpram_map/types', 'SurayParamAttributeController@types'); // get survey types
Route::middleware('auth:api')->get('/survey/attrpram_map/values/id/{id}', 'SurayParamAttributeController@values'); // get values of a given attribute id
Route::middleware('auth:api')->get('/survey/attrpram_map/table/id/{id}', 'SurayParamAttributeController@table'); // get values of a given attribute id
Route::middleware('auth:api')->get('/survey/attrpram_map/attr/{id}', 'SurayParamAttributeController@assigned'); // get values of a given attribute id
Route::middleware('auth:api')->get('/survey/attrpram_map/attr_option/{id}', 'SurayParamAttributeController@assignedOption'); // get values of a given attribute id

// {
//     "survey_parameter_id":"1",
//     "survey_attribute_id":"1",
//     "type":"selected"

// }

/*
 * survey result
 */

Route::middleware('auth:api')->post('/survey/result', 'SurveyResultController@create'); // create a result
Route::middleware('auth:api')->get('/survey/result/mapId/{id}', 'SurveyResultController@all'); // get results by map id
Route::middleware('auth:api')->get('/survey/result/id/{id}', 'SurveyResultController@find'); // get result by id
Route::middleware('auth:api')->put('/survey/result/id/{id}', 'SurveyResultController@update'); // update
Route::middleware('auth:api')->delete('/survey/result/id/{id}', 'SurveyResultController@delete'); // delete

// {
//     "suray_param_attribute_id": "11",
//     "type": "NUMERIC",
//     "value": "10",
//     "survey_session_id" : "1"
// }

/*
 * survey sessions
 */

Route::middleware('auth:api')->post('/survey/session', 'SurveySessionController@create'); // create a result
Route::middleware('auth:api')->get('/survey/sessions', 'SurveySessionController@index'); // get all
Route::middleware('auth:api')->get('/survey/session/id/{id}', 'SurveySessionController@show'); // get titles by session id
Route::middleware('auth:api')->put('/survey/session/id/{id}', 'SurveySessionController@update'); // update only name
Route::middleware('auth:api')->delete('/survey/session/id/{id}', 'SurveySessionController@destroy'); // delete
Route::middleware('auth:api')->post('/survey/session/start/id/{id}', 'SurveySessionController@start'); // start session
Route::middleware('auth:api')->post('/survey/session/end/id/{id}', 'SurveySessionController@end'); // end session

//  {
//      "name": "Hansana",
//      "start_date": "2019-01-01",
//      "year": "1995",
//      "end_date": "2020-01-01",
//      "titles":[1,2]

//  }
