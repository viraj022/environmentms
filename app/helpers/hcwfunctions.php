<?php

use App\Client;
use App\Minute;
use App\FileLog;
use App\Setting;

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
    $file = Client::findOrFail($fileId);
    switch ($statusType) {
        case 'file_status':
            $file->file_status = $statusCode;
            break;
        case 'inspection':
            $file->need_inspection = $statusCode;
            break;
        case 'cer_type_status':
            $file->cer_type_status = $statusCode;
            break;
        case 'old_data':
            $file->is_old = $statusCode;
            break;
        case 'file_working':
            $file->file_approval_status = $statusCode;
            break;
        case 'cer_status':
            $file->cer_status = $statusCode;
            break;
        case 'file_problem':
            $file->file_problem_status = $statusCode;
            $file->file_problem_status_description = $statusValue;
            break;
        default:
            abort('422', 'unknown status type');
    }
    return $file->save();
}

function fileLog($id, $code, $description,  $authlevel)
{
    $log = [];
    $log['client_id'] = $id;
    $log['code'] =  $code;
    $log['description'] = $description;
    $log['auth_level'] = $authlevel;
    $log['user_id'] = auth()->check() ? auth()->user()->id : "N/A";
    FileLog::create($log);
}

function prepareMinutesArray($file, $description, $situation, $user_id)
{
    // dd($file);
    if ($file->cer_type_status == 1 || $file->cer_type_status == 2) {
        $type = Minute::EPL;
        $type_id = $file->epls->last()->id;
    } else if ($file->cer_type_status == 3 || $file->cer_type_status == 4) {
        $type = Minute::SITE_CLEARANCE;
        $type_id = $file->siteClearenceSessions->last()->id;
    } else {
        abort(501, "Invalid File Status - hcw error code");
    }
    return [
        "file_id" => $file->id,
        "minute_description" => $description,
        "situation" => $situation,
        "file_type" => $type,
        "file_type_id" => $type_id,
        "user_id" => $user_id
    ];
}

function getSerialNumber($name)
{
    /**
     * get serial number in the database
     * not considered the year reset
     */
    $value = Setting::where('name', $name)->first();
    if (!$value) {
        abort('Serial no not found in db-HCW Code');
    }
    return $value->value;
}

function incrementSerial($name)
{
    /**
     * set increment serial number
     * not considered the year reset
     */
    $value = Setting::where('name', $name)->first();
    if (!$value) {
        abort('Serial no not found in db-HCW Code');
    }
    $value->increment('value');
}
