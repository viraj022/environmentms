<?php

Route::middleware('auth:api')->post('/change_file', 'ChangeFileController@changeFile'); //   get cert by id