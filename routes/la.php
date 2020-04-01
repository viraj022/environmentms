<?php
Route::get('/localAuthority', 'LocalAuthorityController@index');
Route::post('/localAuthority','LocalAuthorityController@create');
Route::get('/localAuthority/id/{id}','LocalAuthorityController@edit');
Route::put('/localAuthority/id/{id}','LocalAuthorityController@store');
Route::delete('/localAuthority/id/{id}','LocalAuthorityController@delete');
//
