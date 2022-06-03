<?php

Route::middleware('auth:api')->post('/change_file', 'ChangeFileController@changeFile'); //   get cert by id
Route::middleware('auth:api')->delete('/remove_epl_application', 'ChangeFileController@removeEplApplication'); //   remove epl application 
Route::middleware('auth:api')->delete('/remove_site_application', 'ChangeFileController@removeSiteApplication'); //   remove site application

Route::middleware('auth:api')->post('/fix_file_status', 'ClientController@fixFileStatus'); //   fix file status