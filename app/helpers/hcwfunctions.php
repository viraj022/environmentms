<?php

use App\Client;

function changeDateFormate()
{
    return "h1";
}

function productImagePath($image_name)
{
    return public_path('images/products/' . $image_name);
}

function setFileStatus($fileId, $statusType, $statusCode, $statusValue = '')
{
    $file = Client::findOrfail($fileId);
    switch($statusType){
        case 'file_approval':
            $file->file_approval_status = $statusCode;
        break;
        case 'inspection':
            $file->need_inspection = $statusCode;
        break;
        case 'certificate_type':
            $file->certificate_type_status = $statusCode;
        break;
        case 'old_data':
            $file->is_old = $statusCode;
        break;
        case 'file_working':
            $file->file_approval_status = $statusCode;
        break;
        case 'certificate':
            $file->certificate_status = $statusCode;
        break;
        case 'file_problem':
            $file->file_problem_status = $statusCode;
            $file->file_problem_status_description = $statusValue;
        break;
        default:
        abort('422','unknown status type');
    }
    return $file->save();
}
