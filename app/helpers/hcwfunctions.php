<?php

use App\Client;
use App\Minute;
use App\FileLog;
use App\Setting;
use PhpParser\Node\Expr\Cast\Array_;

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

function monthNames()
{
    return [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];
}
function refineArrayMonth($array)
{
    $rtn = $array;
    if (!array_key_exists('01', $rtn)) {
        $rtn['01'] = 0;
    }
    if (!array_key_exists('02', $rtn)) {
        $rtn['02'] = 0;
    }
    if (!array_key_exists('03', $rtn)) {
        $rtn['03'] = 0;
    }
    if (!array_key_exists('04', $rtn)) {
        $rtn['04'] = 0;
    }
    if (!array_key_exists('05', $rtn)) {
        $rtn['05'] = 0;
    }
    if (!array_key_exists('06', $rtn)) {
        $rtn['06'] = 0;
    }
    if (!array_key_exists('07', $rtn)) {
        $rtn['07'] = 0;
    }
    if (!array_key_exists('08', $rtn)) {
        $rtn['08'] = 0;
    }
    if (!array_key_exists('09', $rtn)) {
        $rtn['09'] = 0;
    }
    if (!array_key_exists(10, $rtn)) {
        $rtn[10] = 0;
    }
    if (!array_key_exists(11, $rtn)) {
        $rtn[11] = 0;
    }
    if (!array_key_exists(12, $rtn)) {
        $rtn[12] = 0;
    }
    return $rtn;
}

function getArraySum($array1, $array2)
{
    $rtn = [];
    $i = 0;
    foreach ($array1 as $a) {
        array_push($rtn, $a + $array2[$i++]);
    }
    return $rtn;
}
