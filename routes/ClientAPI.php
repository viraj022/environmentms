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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
// });
//api
Route::middleware('auth:api')->get('/files/all/officer/id/{id}', 'ClientController@getAllFiles'); // get all files by environment officer
Route::middleware('auth:api')->get('/files/certificate/officer/id/{id}', 'ClientController@certificatePath'); // get all files by certificate Path


Route::middleware('auth:api')->get('/files/working/officer/id/{id}', 'ClientController@workingFiles');  // get working files by environment officer

Route::middleware('auth:api')->get('/files/new/officer/id/{id}', 'ClientController@newlyAssigned'); //  get new files by environment officer


Route::middleware('auth:api')->get('/assistant_directors/level', 'AssistantDirectorController@getAssistanceDirectorsByLevel'); // get assistance director by logged user

Route::middleware('auth:api')->get('/environment_officer/level/assistant_director_id/{id}', 'EnvironmentOfficerController@getEnvironmentOfficersByLevel'); // get environment officer by logged user

Route::middleware('auth:api')->post('/inspection/{inspectionNeed}/file/{id}', 'ClientController@markInspection'); // mark inspection need or not need

/*
  values for inspectionNeed parameter
 * needed
 * no_needed
 */
/*

  {
  "id": 1,
  "message": "true"
  }

 */
Route::middleware('auth:api')->get('/files/need_inspection/officer/id/{id}', 'ClientController@inspection_needed_files'); //  get inspection needed files
Route::middleware('auth:api')->get('/files/need_inspection/pending/officer/id/{id}', 'ClientController@inspection_pending_needed_files'); //  get inspection needed files

Route::middleware('auth:api')->post('/files/file_problem_status/id/{id}', 'ClientController@file_problem_status'); //  set file problem status


Route::middleware('auth:api')->post('/files/status/id/{id}', 'ClientController@changeFileStatus'); //  set file problem status
/*
  {
  "status_type":"file_approval",  // inspection , certificate_type , old_data , file_working , certificate , file_problem
  "status_code" : "approved",
  "status_value" : ""
  }
 */

Route::middleware('auth:api')->get('/files/pending/assistance_director/{id}', 'ClientController@getAssistanceDirectorPendingList'); //  get director pending list
/*
  [
  {
  "id": 21,
  "first_name": "ahan",
  "last_name": "last",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
  "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
  "created_at": "2020-09-04 13:21:02",
  "updated_at": "2020-09-04 13:21:02",
  "deleted_at": null,
  "industry_name": "ahan",
  "industry_category_id": 84,
  "business_scale_id": 2,
  "industry_contact_no": null,
  "industry_address": "kurunegala",
  "industry_email": null,
  "industry_coordinate_x": "7.48905",
  "industry_coordinate_y": "80.349985",
  "pradesheeyasaba_id": 52,
  "industry_is_industry": 0,
  "industry_investment": 15000,
  "industry_start_date": "2020-09-15 00:00:00",
  "industry_registration_no": "ahan/2020",
  "application_path": null,
  "environment_officer_id": null,
  "file_01": null,
  "file_02": null,
  "file_03": null,
  "file_no": "PEA/0903/TCC/M/21/2020",
  "assign_date": null,
  "is_old": 1,
  "need_inspection": null,
  "file_problem_status": "pending",
  "file_problem_status_description": "",
  "file_status": -2,
  "cer_type_status": 0,
  "cer_status": 0,
  "old_files": [],
  "industry_category": {
  "id": 84,
  "name": "climbing",
  "code": "TC",
  "created_at": "2020-09-03 13:28:36",
  "updated_at": "2020-09-07 09:53:41"
  },
  "business_scale": {
  "id": 2,
  "name": "Medium- M(Industries of Category B)",
  "code": "M",
  "created_at": null,
  "updated_at": null
  },
  "pradesheeyasaba": {
  "id": 52,
  "name": "test03",
  "code": "0903",
  "created_at": "2020-09-03 06:11:27",
  "updated_at": "2020-09-03 06:11:27",
  "zone_id": 1
  },
  "environment_officer": null
  },
  ]
 */
Route::middleware('auth:api')->get('/files/pending/environment_officer/{id}', 'ClientController@getEnvironmentOfficerPendingList'); //  get environment officer pending list
/*
  [
  {
  "id": 21,
  "first_name": "ahan",
  "last_name": "last",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
  "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
  "created_at": "2020-09-04 13:21:02",
  "updated_at": "2020-09-04 13:21:02",
  "deleted_at": null,
  "industry_name": "ahan",
  "industry_category_id": 84,
  "business_scale_id": 2,
  "industry_contact_no": null,
  "industry_address": "kurunegala",
  "industry_email": null,
  "industry_coordinate_x": "7.48905",
  "industry_coordinate_y": "80.349985",
  "pradesheeyasaba_id": 52,
  "industry_is_industry": 0,
  "industry_investment": 15000,
  "industry_start_date": "2020-09-15 00:00:00",
  "industry_registration_no": "ahan/2020",
  "application_path": null,
  "environment_officer_id": null,
  "file_01": null,
  "file_02": null,
  "file_03": null,
  "file_no": "PEA/0903/TCC/M/21/2020",
  "assign_date": null,
  "is_old": 1,
  "need_inspection": null,
  "file_problem_status": "pending",
  "file_problem_status_description": "",
  "file_status": -2,
  "cer_type_status": 0,
  "cer_status": 0,
  "old_files": [],
  "industry_category": {
  "id": 84,
  "name": "climbing",
  "code": "TC",
  "created_at": "2020-09-03 13:28:36",
  "updated_at": "2020-09-07 09:53:41"
  },
  "business_scale": {
  "id": 2,
  "name": "Medium- M(Industries of Category B)",
  "code": "M",
  "created_at": null,
  "updated_at": null
  },
  "pradesheeyasaba": {
  "id": 52,
  "name": "test03",
  "code": "0903",
  "created_at": "2020-09-03 06:11:27",
  "updated_at": "2020-09-03 06:11:27",
  "zone_id": 1
  },
  "environment_officer": null
  },
  ]
 */
Route::middleware('auth:api')->get('/files/pending/director', 'ClientController@getDirectorPendingList'); //  get director pending list
/*
  [
  {
  "id": 21,
  "first_name": "ahan",
  "last_name": "last",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
  "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
  "created_at": "2020-09-04 13:21:02",
  "updated_at": "2020-09-04 13:21:02",
  "deleted_at": null,
  "industry_name": "ahan",
  "industry_category_id": 84,
  "business_scale_id": 2,
  "industry_contact_no": null,
  "industry_address": "kurunegala",
  "industry_email": null,
  "industry_coordinate_x": "7.48905",
  "industry_coordinate_y": "80.349985",
  "pradesheeyasaba_id": 52,
  "industry_is_industry": 0,
  "industry_investment": 15000,
  "industry_start_date": "2020-09-15 00:00:00",
  "industry_registration_no": "ahan/2020",
  "application_path": null,
  "environment_officer_id": null,
  "file_01": null,
  "file_02": null,
  "file_03": null,
  "file_no": "PEA/0903/TCC/M/21/2020",
  "assign_date": null,
  "is_old": 1,
  "need_inspection": null,
  "file_problem_status": "pending",
  "file_problem_status_description": "",
  "file_status": -2,
  "cer_type_status": 0,
  "cer_status": 0,
  "old_files": [],
  "industry_category": {
  "id": 84,
  "name": "climbing",
  "code": "TC",
  "created_at": "2020-09-03 13:28:36",
  "updated_at": "2020-09-07 09:53:41"
  },
  "business_scale": {
  "id": 2,
  "name": "Medium- M(Industries of Category B)",
  "code": "M",
  "created_at": null,
  "updated_at": null
  },
  "pradesheeyasaba": {
  "id": 52,
  "name": "test03",
  "code": "0903",
  "created_at": "2020-09-03 06:11:27",
  "updated_at": "2020-09-03 06:11:27",
  "zone_id": 1
  },
  "environment_officer": null
  }
  ]
 */
Route::middleware('auth:api')->get('/files/certificate_drafting/status/{status}', 'ClientController@getCertificateDraftingList'); //  get Certificate Drafting List
/*
  [
  {
  "id": 21,
  "first_name": "ahan",
  "last_name": "last",
  "address": null,
  "contact_no": null,
  "email": null,
  "nic": null,
  "password": "$2y$10$0dGuZ91Q/DnMByDd8rBfVOPzQHbaUfnYNuR6WMbQk7ustwx.tw/AW",
  "api_token": "DPBaiY4knc4wcpDLq45z6u7vN2y3Dz9HO0VnxNFM7At3GQiI5n6oNkqxNFGaeAbCqKX6v5JpJPhEjxQ3",
  "created_at": "2020-09-04 13:21:02",
  "updated_at": "2020-09-04 13:21:02",
  "deleted_at": null,
  "industry_name": "ahan",
  "industry_category_id": 84,
  "business_scale_id": 2,
  "industry_contact_no": null,
  "industry_address": "kurunegala",
  "industry_email": null,
  "industry_coordinate_x": "7.48905",
  "industry_coordinate_y": "80.349985",
  "pradesheeyasaba_id": 52,
  "industry_is_industry": 0,
  "industry_investment": 15000,
  "industry_start_date": "2020-09-15 00:00:00",
  "industry_registration_no": "ahan/2020",
  "application_path": null,
  "environment_officer_id": null,
  "file_01": null,
  "file_02": null,
  "file_03": null,
  "file_no": "PEA/0903/TCC/M/21/2020",
  "assign_date": null,
  "is_old": 1,
  "need_inspection": null,
  "file_problem_status": "pending",
  "file_problem_status_description": "",
  "file_status": -2,
  "cer_type_status": 0,
  "cer_status": 0,
  "old_files": [],
  "industry_category": {
  "id": 84,
  "name": "climbing",
  "code": "TC",
  "created_at": "2020-09-03 13:28:36",
  "updated_at": "2020-09-07 09:53:41"
  },
  "business_scale": {
  "id": 2,
  "name": "Medium- M(Industries of Category B)",
  "code": "M",
  "created_at": null,
  "updated_at": null
  },
  "pradesheeyasaba": {
  "id": 52,
  "name": "test03",
  "code": "0903",
  "created_at": "2020-09-03 06:11:27",
  "updated_at": "2020-09-03 06:11:27",
  "zone_id": 1
  },
  "environment_officer": null
  }
  ]
 */



Route::middleware('auth:api')->post('/start_drafting/id/{id}', 'ClientController@nextCertificateNumber'); //  start certificate drafting



/*
  {
  "nextNumber": "000001"
  } */


Route::middleware('auth:api')->get('/working_certificate/file/{file}', 'ClientController@getCertificateDetails'); //  get Working certificate



/*
  {
  "id": 1,
  "client_id": 16,
  "certificate_type": 456,
  "cetificate_number": "dsada",
  "issue_date": "2020-09-12 18:42:52",
  "issue_status": 0,
  "user_id": 41,
  "certificate_path": "dsad",
  "signed_certificate_path": "dsad",
  "created_at": "2020-09-12 18:42:52",
  "updated_at": "2020-09-12 18:42:52",
  "deleted_at": null,
  "client": {
  "id": 16,
  "first_name": "light",
  "last_name": "blue",
  "address": "file_approval",
  "contact_no": null,
  "email": null,
  "nic": null,
  "password": "$2y$10$87AzS.8pAr6U8TrQFbpPq.xilz9nOQSfo2lUD5eDXkL3pQ62hFmAG",
  "api_token": "m4uX4kHcTBmGe2VSnbke0x5lXUGZPxrLZKYDjR6JJADusfjnLWsr1lKcfm4vI9QRtE8ZROzN7QfHhAVF",
  "created_at": "2020-09-03 16:11:56",
  "updated_at": "2020-09-12 17:58:51",
  "deleted_at": null,
  "industry_name": "testindustry",
  "industry_category_id": 5,
  "business_scale_id": 2,
  "industry_contact_no": null,
  "industry_address": "kurunegala",
  "industry_email": null,
  "industry_coordinate_x": "7.48905",
  "industry_coordinate_y": "80.349985",
  "pradesheeyasaba_id": 54,
  "industry_is_industry": 0,
  "industry_investment": 1000,
  "industry_start_date": "2020-06-30 00:00:00",
  "industry_registration_no": "light/2020",
  "application_path": "uploads/industry_files/16/application/1599130463.pdf",
  "environment_officer_id": 10,
  "file_01": "uploads/industry_files/16/application/file1/1599218113.png",
  "file_02": "uploads/industry_files/16/application/file2/1599218121.jpeg",
  "file_03": "uploads/industry_files/16/application/file3/1599218127.png",
  "file_no": "PEA/604//3/AG/M/16/2020",
  "assign_date": "2020-09-04 12:06:01",
  "is_old": 1,
  "need_inspection": null,
  "file_problem_status": "pending",
  "file_problem_status_description": "",
  "file_status": -2,
  "cer_type_status": 0,
  "cer_status": -1
  }
  }
 */

Route::middleware('auth:api')->post('/certificate/draft/{id}', 'ClientController@uploadCertificate'); //  upload certificate draft
Route::middleware('auth:api')->post('/certificate/corrected_file/{id}', 'ClientController@uploadCorrectedFile'); //  upload corrected file
Route::middleware('auth:api')->post('/certificate/original/{id}', 'ClientController@uploadOriginalCertificate'); //  upload certificate original

Route::middleware('auth:api')->post('/certificate/drafted/{id}', 'ClientController@completeDraftingCertificate'); //  make certificate drafted
Route::middleware('auth:api')->post('/certificate/issue/{id}', 'ClientController@issueCertificate'); //  certificate issued

Route::middleware('auth:api')->post('/certificate/complete/{id}', 'ClientController@completeCertificate'); //  complete certificate
Route::middleware('auth:api')->get('/certificate/expiredCertificates', 'ClientController@getExpiredCertificates'); //  get all Expired Certificates and certificate that expired within  a month by environment
Route::middleware('auth:api')->get('/old_files/count_by_date', 'ClientController@oldFilesCountByDate');

Route::middleware('auth:api')->post('/reject/file/{file_id}', 'AssistantDirectorController@rejectFileAll'); //   reject file and current working file type


//report api
Route::middleware('auth:api')->get('/files/confirmed', 'ClientController@getCofirmedFiles'); //   get confirmed files

Route::middleware('auth:api')->get('/files/approved/director', 'ClientController@getDirectorApprovedList'); //  get director approved list
Route::middleware('auth:api')->post('/certificate/word/cert_id/{cert_id}', 'ClientController@uploadDocumentFile'); //  upload document file
Route::middleware('auth:api')->post('/pendingExpiredCert', 'ClientController@getPendingExpiredCertificates'); //  get all Expired Certificates and certificate that expired within  a month by environment

//change file status to 0 (pending)
Route::middleware('auth:api')->post('/change_file_status/id/{client_id}', 'ClientController@changeStatus'); //  change file status
