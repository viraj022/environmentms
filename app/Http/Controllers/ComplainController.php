<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\contactNo;
use Illuminate\Support\Facades\Auth;
use App\Complain;

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
            "file_list" => 'required'
        ]);

        $save_complain = Complain::create([
            "complainer_name" => $request->complainer_name_ipt,
            "complainer_address" => $request->complainer_address_ipt,
            "comp_contact_no" => $request->contact_complainer_ipt,
            "recieve_type" => $request->recieve_type_ipt,
            "complain_des" => $request->complain_desc_ipt,
            "complainer_code" => $request->complainer_code,
            "created_user" =>  $user,
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
            $save_complain->save();
        }

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
            "file_list" => 'required'
        ]);

        $update_complain = Complain::find($id);
        $update_complain->complainer_name = $request->complainer_name_ipt;
        $update_complain->complainer_address = $request->complainer_address_ipt;
        $update_complain->comp_contact_no = $request->contact_complainer_ipt;
        $update_complain->recieve_type = $request->recieve_type_ipt;
        $update_complain->complain_des = $request->complain_desc_ipt;
        $update_complain->complainer_code = $request->complainer_code;
        $update_complain->created_user = $user;

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
            $update_complain->save();
        }

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
        $complain_data = Complain::find($id);
        return view('complain_profile', ['complain_id' => $id]);
    }

    public function complainProfileData($id)
    {
        $complain_data = Complain::with(['assignedUser', 'createdUser'])->find($id);
        return $complain_data;
    }

    public function update_attachments(Request $request, $id)
    {
        $user = Auth::user()->id;
        $update_attach = Complain::find($id);
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

            $update_attach->attachment = json_encode($Arr);
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
}
