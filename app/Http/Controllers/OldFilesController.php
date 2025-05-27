<?php

namespace App\Http\Controllers;

use App\Client;
use App\OldFiles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;

class OldFilesController extends Controller
{

    public function create($id, Request $request)
    {
        request()->validate([
            'file' => 'required|mimes:jpeg,jpg,png,pdf',
            'description' => 'sometimes|required|string',
            'file_catagory' => 'required|string'
        ]);
        $client = Client::findOrFail($id);
        // if ($client->is_old != 0) {
        //     return array('id' => 0, 'message' => 'This File is old file, you can not add new files to this client');
        // }
        $fileUrl = 'uploads/' . FieUploadController::getOldFilePath($client);
        // dd($fileUrl);
        $path = $request->file('file')->store($fileUrl);
        // dd($path);
        if (!$path) {
            return array('id' => 0, 'message' => 'false');
        }
        $oldFiles = new OldFiles();
        $oldFiles->path = $path;
        $oldFiles->type = $request->file->extension();
        $oldFiles->client_id = $client->id;
        $oldFiles->description = \request('description');
        $oldFiles->file_catagory = \request('file_catagory');
        $msg = $oldFiles->save();
        LogActivity::fileLog($oldFiles->client_id, 'old_file', "OldFileCreate", 1, 'old file', '');
        LogActivity::addToLog('OldFileCreate Created', $oldFiles);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $oldFiles = OldFiles::findOrFail($id);
        $msg = $oldFiles->delete();
        if (!$msg) {
            return array('id' => 0, 'message' => 'false');
        }
        LogActivity::fileLog($oldFiles->client_id, 'old_file', "OldFileDelate", 1, 'old file', '');
        LogActivity::addToLog('OldFileCreate Deleted', $oldFiles);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }
}
