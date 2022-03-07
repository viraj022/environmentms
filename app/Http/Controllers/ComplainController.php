<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\contactNo;
use Illuminate\Support\Facades\Auth;
use App\Complain;
use App\ComplainComment;
use App\ComplainMinute;
use App\ComplainAssignLog;
use App\Client;
use Illuminate\Support\Facades\Log;

class ComplainController extends Controller
{

    public function index()
    {
        return view('complains');
    }

    public function save_complain(Request $request)
    {
        $user = Auth::user()->id;
        request()->validate([
            "complainer_name_ipt" => 'required|max:255|string',
            "complainer_address_ipt" => 'required|max:255|string',
            "contact_complainer_ipt" => ['required', 'numeric', 'nullable', 'min:10'],
            "recieve_type_ipt" => 'required',
            "complain_desc_ipt" => 'required|max:255|string',
            "complainer_code" => 'required|max:255|string',
            // "file_list" => 'required',
            "pradeshiya_saba_id" => 'required'
        ]);

        $save_complain = Complain::create([
            "complainer_name" => $request->complainer_name_ipt,
            "complainer_address" => $request->complainer_address_ipt,
            "comp_contact_no" => $request->contact_complainer_ipt,
            "recieve_type" => $request->recieve_type_ipt,
            "complain_des" => $request->complain_desc_ipt,
            "complainer_code" => $request->complainer_code,
            "created_user" =>  $user,
            "pradeshiya_saba_id" => $request->pradeshiya_saba_id,
        ]);
        $files = $request->file_list;
        if ($files != null) {
            $Arr = array();
            foreach ($files as $file) {
                $attach = $file->store('public/complain_attachments/' . $save_complain->id);
                $Arr[] = [
                    'img_path' => str_replace('public/', '', $attach),
                    'upload_time' => date("Y-m-d H:i:s"),
                    'uploaded_user' => $user
                ];
            }

            $save_complain->attachment = json_encode($Arr);
        }
        $save_complain->save();

        if ($save_complain == true) {
            return array('status' => 1, 'msg' => 'Complain successfully saved');
        } else {
            return array('status' => 0, 'msg' => 'Complain save unsuccessful');
        }
    }

    public function update_complain(Request $request, $id)
    {
        $user = Auth::user()->id;
        request()->validate([
            "complainer_name_ipt" => 'required|max:255|string',
            "complainer_address_ipt" => 'required|max:255|string',
            "contact_complainer_ipt" => ['required', 'numeric', 'nullable', 'min:10'],
            "recieve_type_ipt" => 'required',
            "complain_desc_ipt" => 'required|max:255|string',
            "complainer_code" => 'required|max:255|string',
            // "file_list" => 'required',
            "pradeshiya_saba_id" => 'required'
        ]);

        $update_complain = Complain::find($id);
        $update_complain->complainer_name = $request->complainer_name_ipt;
        $update_complain->complainer_address = $request->complainer_address_ipt;
        $update_complain->comp_contact_no = $request->contact_complainer_ipt;
        $update_complain->recieve_type = $request->recieve_type_ipt;
        $update_complain->complain_des = $request->complain_desc_ipt;
        $update_complain->complainer_code = $request->complainer_code;
        $update_complain->created_user = $user;
        $update_complain->pradeshiya_saba_id = $request->pradeshiya_saba_id;
        $files = $request->file_list;

        if ($files != null) {
            $Arr = array();
            foreach ($files as $file) {
                $attach = $file->store('public/complain_attachments/' . $id);
                $Arr[] = [
                    'img_path' => str_replace('public/', '', $attach),
                    'upload_time' => date("Y-m-d H:i:s"),
                    'uploaded_user' => $user
                ];
            }

            $update_complain->attachment = json_encode($Arr);
        }
        $update_complain->save();

        if ($update_complain == true) {
            return array('status' => 1, 'msg' => 'Complain successfully updated');
        } else {
            return array('status' => 0, 'msg' => 'Complain update unsuccessful');
        }
    }

    public function show()
    {
        $complains = Complain::with(['createdUser', 'assignedUser'])->get();
        return $complains;
    }

    public function complainProfile($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.complains'));
        return view('complain_profile', ['complain_id' => $id, 'pageAuth' => $pageAuth]);
    }

    public function complainProfileData($id)
    {
        $complain_data = Complain::with(['assignedUser', 'createdUser', 'complainComments', 'complainMinutes'])->find($id);
        return $complain_data;
    }

    public function update_attachments(Request $request, $id)
    {
        $user = Auth::user()->id;
        $update_attach = Complain::find($id);
         $curr_file_path_arr = json_decode($update_attach->attachment);
        $files = $request->file_list;
        if ($files != null) {
            foreach ($files as $file) {
                $attach = $file->store('public/complain_attachments/' . $id);
                $curr_file_path_arr[] = [
                    'img_path' => str_replace('public/', '', $attach),
                    'upload_time' => date("Y-m-d H:i:s"),
                    'uploaded_user' => $user
                ];

            }

            $update_attach->attachment = json_encode($curr_file_path_arr);
            $update_attach->save();
        }

        if ($update_attach == true) {
            return array('status' => 1, 'msg' => 'Complain attachments successfully changed');
        } else {
            return array('status' => 0, 'msg' => 'Complain attachments change is unsuccessful');
        }
    }

    public function delete_complain($id)
    {
        $delete_complain = Complain::find($id)->delete();
        if ($delete_complain == true) {
            return array('status' => 1, 'msg' => 'Complain successfully deleted');
        } else {
            return array('status' => 0, 'msg' => 'Complain delete unsuccessful');
        }
    }

    public function assign_complain_to_user($complain_id, $assignee_id)
    {
        $assigner_id = Auth::user()->id;
        try {
            \DB::beginTransaction();
            $assign_complain = Complain::find($complain_id);

            $assign_complain->assigned_user = $assignee_id;
            $assign_complain->created_user = $assigner_id;
            $assign_complain->save();

            ComplainAssignLog::create([
                "complain_id" => $complain_id,
                "assigner_user" => $assigner_id,
                "assignee_user" => $assignee_id,
                "assigned_time" => date("Y-m-d H:i:s"),
            ]);


            \DB::commit();
            return array('status' => 1, 'msg' => 'Complain assign successful');
        } catch (\Exception $e) {
            \DB::rollBack();
            return array('status' => 0, 'msg' => 'Complain assign unsuccessful');
        }
    }

    public function add_comment_to_complain(Request $request)
    {
        $user_id = Auth::user()->id;
        $save_complain_comment = new ComplainComment();
        $save_complain_comment->comment = $request->comment;
        $save_complain_comment->complain_id = $request->comp_comnt_hid_id;
        $save_complain_comment->commented_user_id = $user_id;
        $save_complain_comment->save();

        if ($save_complain_comment == true) {
            return array('status' => 1, 'msg' => 'Complain comment addition successful');
        } else {
            return array('status' => 0, 'msg' => 'Complain comment addition unsuccessful');
        }
    }

    public function add_minute_to_complain(Request $request)
    {
        $user_id = Auth::user()->id;
        $save_complain_minute = new ComplainMinute();
        $save_complain_minute->minute = $request->minute;
        $save_complain_minute->complain_id = $request->comp_minute_hid_id;
        $save_complain_minute->minute_user_id = $user_id;
        $save_complain_minute->save();

        if ($save_complain_minute == true) {
            return array('status' => 1, 'msg' => 'Complain comment addition successful');
        } else {
            return array('status' => 0, 'msg' => 'Complain comment addition unsuccessful');
        }
    }

    public function confirm_complain($complain_id)
    {
        $confirm_complain = Complain::find($complain_id);
        $confirm_complain->status = 1;
        $confirm_complain->save();

        if ($confirm_complain == true) {
            return array('status' => 1, 'msg' => 'Complain confirmation is successful');
        } else {
            return array('status' => 0, 'msg' => 'Complain confirmation was unsuccessful');
        }
    }

    public function reject_complain($complain_id)
    {
        $confirm_complain = Complain::find($complain_id);
        $confirm_complain->status = -1;
        $confirm_complain->save();

        if ($confirm_complain == true) {
            return array('status' => 1, 'msg' => 'Complain rejection is successful');
        } else {
            return array('status' => 0, 'msg' => 'Complain rejection was unsuccessful');
        }
    }

    public function forward_to_letter_preforation($complain_id)
    {
        $confirm_complain = Complain::find($complain_id);
        $confirm_complain->status = 4;
        $confirm_complain->save();

        if ($confirm_complain == true) {
            return array('status' => 1, 'msg' => 'Forward letter preforation is successful');
        } else {
            return array('status' => 0, 'msg' => 'Forward letter preforation was unsuccessful');
        }
    }

    public function get_complain_assign_log($complain_id)
    {
        $complain_assign_log = ComplainAssignLog::where('complain_id', $complain_id)
            ->with(['assignerUser', 'assigneeUser'])
            ->get();
        return $complain_assign_log;
    }

    public function forwarded_complains(){
        $forwarded_complains = Complain::where('status', 4)->get();
        return $forwarded_complains;
    }

    public function removeAttach(Request $request){
        $attach = Complain::find($request->id);
        $decoded_paths = json_decode($attach->attachment);
        foreach($decoded_paths as $decoded_path){
            if($decoded_path->img_path == $request->file_path){
                $decoded_path->img_path = '';
            }
        }
        $encoded_path = json_encode($decoded_paths);
        $attach->attachment = $encoded_path;
        $attach->save();
        if ($attach == true) {
            return array('status' => 1, 'msg' => 'Complain attachments successfully removed');
        } else {
            return array('status' => 0, 'msg' => 'Complain attachments removal was unsuccessful');
        }
    }

    public function loadFileNo(){
        $file_no = Client::select('id', 'file_no')->get();
        return $file_no;
    }

    public function assignFileNo(Request $request){
        $assign_file = Complain::find($request->id);
        $assign_file->client_id = $request->client_id;
        $assign_file->save();
        if($assign_file == true){
            return array('status' => 1, 'msg' => 'File assigned successfully');
        }else{
            return array('status' => 0, 'msg' => 'File assigning was unsuccessful');
        }
    }
}
