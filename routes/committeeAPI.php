<?php
Route::get('/committees/{attribute}/{value}', 'CommitteeController@attribute');
Route::apiResource('/committees', 'CommitteeController');

/**
 * input data
 * {
  "name": "hansana",
  "site_clearence_session_id" : 1,
  "schedule_date": "2020-01-01"

}
 */
/**
 * output data
 * 
    {
        "id": 1,
        "name": "hansana",
        "site_clearence_session_id": 1,
        "client_id": 24,
        "remark": null,
        "schedule_date": "2020-01-01",
        "created_at": "2020-09-22 18:22:22",
        "updated_at": "2020-09-22 18:22:22",
        "deleted_at": null,
        "site_clearence_session": {
            "id": 1,
            "code": "ASSSer",
            "remark": "AER",
            "client_id": 24,
            "site_clearance_type": "Site Clearance",
            "processing_status": 0,
            "created_at": "2020-09-03 14:41:09",
            "updated_at": "2020-09-03 14:58:40",
            "deleted_at": null,
            "client": {
                "id": 24,
                "name_title": "",
                "first_name": "Old user",
                "last_name": "Data",
                "address": "Kurunawagama",
                "contact_no": "0776767654",
                "email": "aeaeaea@cc.mm",
                "nic": "676756765v",
                "password": "$2y$10$xF7nWVOTejIg1eCV0njiLe/3mwpIxIlr7Df8dfsGm/tBvPv4HQb4O",
                "api_token": "TLaczDUeF272tvtQj7YkhRSZ1gKQmcuEZhtmbXQ4hDIkCoPlNjFhisKSGRilN26uMU7yseWzXrvb6PXf",
                "created_at": "2020-09-03 14:28:59",
                "updated_at": "2020-09-07 12:48:33",
                "deleted_at": null,
                "industry_name": "CaTME",
                "industry_category_id": 5,
                "business_scale_id": 1,
                "industry_contact_no": "0771212345",
                "industry_address": "Kurunawagama",
                "industry_email": "pass@cc.com",
                "industry_coordinate_x": "7.48905",
                "industry_coordinate_y": "80.349985",
                "pradesheeyasaba_id": 10,
                "industry_is_industry": 0,
                "industry_investment": 10000,
                "industry_start_date": "2020-01-01 00:00:00",
                "industry_registration_no": "AE545",
                "application_path": null,
                "environment_officer_id": 4,
                "file_01": "storage/uploads/industry_files/24/application/file1/1599214250.png",
                "file_02": "storage/uploads/industry_files/24/application/file2/1599214324.png",
                "file_03": "storage/uploads/industry_files/24/application/file3/1599214427.jpeg",
                "file_no": "PEA/PKG/AG/S/24/2020",
                "assign_date": null,
                "is_old": 0,
                "need_inspection": "Inspection Not Needed",
                "file_problem_status": "clean",
                "file_problem_status_description": "NO-PROBLEM",
                "file_status": 0,
                "cer_type_status": 1,
                "cer_status": 0,
                "start_date_only": "2020-01-01"
            }
        }
    }    
 */

/**
 * Response
 *{
    "id": 1,
    "message": "true"
  }  
 */
