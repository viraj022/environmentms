<?php
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/localAuthority/province/id/{id}','LocalAuthorityController@getLocalAuthorityByProvince');