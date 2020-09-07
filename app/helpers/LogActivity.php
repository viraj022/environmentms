<?php


namespace App\Helpers;

use App\LogActivity as LogActivityModel;
use App\FileLog;

class LogActivity
{
    public static function addToLog($subject, $model, $response = array('code' => 0, 'data' => 'N/A'))
    {
        $log = [];
        if (!is_subclass_of($model, 'IllPuminate\Database\Eloquent\Model')) {
            // not a model
            $log['table'] = "";
            $log['field'] = 0;
        } else {
            $log['table'] = $model->getTable();
            $log['field'] = $model->id;
        }
        $log['subject'] = $subject;
        $log['user_id'] = auth()->check() ? auth()->user()->id : "N/A";
        $log['url'] = request()->fullUrl();
        $log['ip'] = request()->ip();
        $log['method'] = request()->method();
        $log['headers'] = json_encode(request()->header());
        $log['request_data'] = json_encode(request()->all());
        $log['response_code'] = $response['code'];
        $log['response_data'] = $response['data'];

        LogActivityModel::create($log);
    }

    public static function fileLog($file, $code, $description,  $authlevel)
    {
        if (!is_subclass_of($$file, 'IllPuminate\Database\Eloquent\Model')) {
            // not a model
            abort(422);
        }
        $log['id'] = $file->id;
        $log['code'] =  $code;
        $log['description'] = $description;
        $log['auth_level'] = $authlevel;
        $log['user_id'] = auth()->check() ? auth()->user()->id : "N/A";
        FileLog::create($log);
    }



    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }

    public static function getFileLogAll()
    {
        return FileLog::all();
    }
    public static function getFileLogByCode($code, $id)
    {
        return FileLog::where('client_id', $id)->whereIn('code', $code)->get();
    }
    public static function getFileLogByLevel($id, $level)
    {
        return FileLog::where('client_id', $id)->whereIn('level', $level)->get();
    }

    public static function getFileLogByLevelAndCode($id, $code, $level)
    {
        return FileLog::where('client_id', $id)->whereIn('code', $code)->whereIn('level', $level)->get();
    }
}
