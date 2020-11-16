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
            'file' => 'required|mimes:jpeg,jpg,png,pdf'
        ]);
        $client = Client::findOrFail($id);
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
        $fileUrl = '/uploads/' . FieUploadController::getOldFilePath($client);
        $storePath = 'public' . $fileUrl;
        $path = $request->file('file')->storeAs($storePath, $file_name);
        $oldFiles = new OldFiles();
        $oldFiles->path = "storage" . $fileUrl . "/" . $file_name;
        $oldFiles->type = $request->file->extension();
        $oldFiles->client_id = $client->id;
        $msg = $oldFiles->save();
        LogActivity::fileLog($oldFiles->client_id, 'OldFile', "OldFileCreate", 1);
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

        LogActivity::fileLog($oldFiles->client_id, 'OldFile', "OldFileDelate", 1);
        LogActivity::addToLog('OldFileCreate Deleted', $oldFiles);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }
}
