<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Complain;

class ComplainController extends Controller {

    public function index() {
        return view('complains');
    }

    public function save_complain(Request $request) {

        request()->validate([
            "compliner_name" => 'required|max:255|string',
            "compliner_address" => 'required|max:255|string',
            "comp_contact_no" => ['required', 'numeric', 'nullable', 'min:10', new contactNo],
            "recieve_type" => 'required',
            "complain_des" => 'required|max:255|string',
        ]);

        $save_complain = Complain::create([
                    "compliner_name",
                    "compliner_address",
                    "comp_contact_no",
                    "recieve_type",
                    "complain_des",
        ]);

        if ($save_complain == true) {
            return array('status' => 1, 'msg' => 'Complain successfully saved');
        } else {
            return array('status' => 0, 'msg' => 'Complain save unsuccessful');
        }
    }

    public function update_complain(Request $request, $id) {

        $update_complain = Complain::find($id);
        $update_complain->compliner_name = $request->complainer_name_ipt;
        $update_complain->compliner_address = $request->complainer_address_ipt;
        $update_complain->comp_contact_no = $request->contact_complainer_ipt;
        $update_complain->recieve_type = $request->recieve_type_ipt;
        $update_complain->complain_des = $request->complainer_name_ipt;
        $update_complain->save();

        if ($save_complain == true) {
            return array('status' => 1, 'msg' => 'Complain successfully updated');
        } else {
            return array('status' => 0, 'msg' => 'Complain update unsuccessful');
        }
    }

    public function show() {
        $complains = Complain::all();
        return $complains;
    }

    public function complainProfile($id) {
        $complain_data = Complain::find($id);
        return view('complain_profile', ['complain_id' => $id]);
    }
    
    public function complainProfileData($id){
        $complain_data = Complain::with(['assignedUser','createdUser'])->find($id);
        return $complain_data;
    }

    public function delete_complain($id) {
        $delete_complain = Complain::find($id)->delete();
        if ($delete_complain == true) {
            return array('status' => 1, 'msg' => 'Complain successfully deleted');
        } else {
            return array('status' => 0, 'msg' => 'Complain delete unsuccessful');
        }
    }

}
