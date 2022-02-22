<?php

Route::middleware('auth:api')->post('/save_reference_no', 'CertificateRefferenceController@saveReferenceNo');