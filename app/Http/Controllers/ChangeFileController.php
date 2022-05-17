<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Client;
use App\EPL;
use App\SiteClearance;
use App\SiteClearenceSession;
use File;

class ChangeFileController extends Controller
{
    public function changeFile(Request $request)
    {
        if ($request['type'] == 'epl') {
            $epl = Epl::find($request['epl_id']);
            $client_id = $epl->client_id;
            if ($request->hasFile('file_list')) {
                $file_name = Carbon::now()->timestamp . '.' . $request->file_list[0]->extension();
                $fileUrl = '/uploads/industry_files/' . $client_id . '/application';
                $storePath = 'public' . $fileUrl;
                $request->file_list[0]->storeAs($storePath, $file_name);
                $epl->path = "storage/" . $fileUrl . "/" . $file_name;
            }
            $status = $epl->save();
        } else {
            $site_clear = SiteClearance::where('site_clearence_session_id', $request['site_clear_sess_id'])->first();
            $file_name = Carbon::now()->timestamp . '.' . $request['file_list'][0]->extension();
            $siteSessions = SiteClearenceSession::find($request['site_clear_sess_id']);
            $fileUrl = '/uploads/' . FieUploadController::getSiteClearanceAPPLICATIONFilePath($siteSessions);
            $storePath = 'public' . $fileUrl;
            $path = $request['file_list'][0]->storeAs($storePath, $file_name);
            $site_clear->application_path = "storage" . $fileUrl . "/" . $file_name;
            $status = $site_clear->save();
        }

        if ($status == true) {
            return array('status' => 1, 'message' => 'File uploaded successfully');
        } else {
            return array('status' => 0, 'message' => 'File has not uploaded successfully');
        }
    }

    public function removeEplApplication(Request $request){
    
       $file_path = $request['file_path'];
       $epl_id = $request['epl_id'];
       $delete_file = Epl::find($epl_id);
       $delete_file->path = '';

       $delete_status = false;
       if (File::exists(public_path($file_path))) {
           $delete_status = unlink(public_path($file_path));
       }

       $delete_file->save();

       if($delete_status == true && $delete_file == true){
           return array('status' => 1, 'message' => 'File deleted successfully');
       }else{
           return array('status' => 0, 'message' => 'File has not deleted successfully');
       }

    }

    public function removeSiteApplication(Request $request){
    
        $file_path = $request['file_path'];
        $site_sess_id = $request['site_sess_id'];
 
        $delete_file = SiteClearance::join('site_clearence_sessions', 'site_clearence_sessions.id', '=', 'site_clearances.site_clearence_session_id')
        ->where('site_clearances.site_clearence_session_id', $site_sess_id)
        ->first();

        $delete_status = false;
        if (File::exists(public_path($file_path))) {
            $delete_status = unlink(public_path($file_path));
        }

        $delete_file->application_path = '';
        $delete_file->save();
 
        if($delete_status == true && $delete_file == true){
            return array('status' => 1, 'message' => 'File deleted successfully');
        }else{
            return array('status' => 0, 'message' => 'File has not deleted successfully');
        }
 
     }
}
