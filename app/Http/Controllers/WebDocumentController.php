<?php

namespace App\Http\Controllers;

use App\Letter;
use App\LetterTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebDocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        return view('document_maker');
    }

    public function save_letter_content(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required',
        ]);
        $first_name = Auth::user()->first_name;
        $last_name = Auth::user()->last_name;
        $user_name = $first_name . ' ' . $last_name;
        if ($validated) {
            $save_letter_content = Letter::create([
                "letter_title" => $request->title,
                "complain_id" => $request->complain_id,
                "status" => 'INPROGRESS',
                "user_name" => $user_name,
            ]);
            if ($request->content != null) {
                $save_letter_content->letter_content = $request->content;
                $save_letter_content->save();
            }
        }

        if ($save_letter_content == true) {
            return array("status" => 1, "message" => "Letter content saved successfully");
        } else {
            return array("status" => 0, "message" => "Letter content saving was unsuccessful");
        }
    }

    public function letters()
    {
        return view('letters');
    }

    public function get_all_letters()
    {
        $all_letters = Letter::all();
        return $all_letters;
    }

    public function get_letter($id)
    {
        $letter = Letter::find($id);
        return View('letter_view', compact('letter'));
    }

    public function get_letter_content($id)
    {
        $letter = Letter::find($id);
        $letter_title = $letter->letter_title;
        $letter_content = $letter->letter_content;
        $letter_status = $letter->status;
        $complain_id = $letter->complain_id;
        return view('document_maker', compact('letter_title', 'id', 'letter_content', 'letter_status', 'complain_id'));
    }

    public function update_letter_content(Request $request)
    {

        $validated = $request->validate([
            'letter_id' => 'required',
            'content' => 'required',
        ]);
        $first_name = Auth::user()->first_name;
        $last_name = Auth::user()->last_name;
        $user_name = $first_name . ' ' . $last_name;
        if ($validated) {
            $update_letter_content = Letter::find($request->letter_id);
            $update_letter_content->letter_title = $request->letter_title;
            $update_letter_content->letter_content = $request->content;
            $update_letter_content->user_name = $user_name;
            $status = $update_letter_content->save();
        }

        if ($status == true) {
            return array("status" => 1, "message" => "Letter content saved successfully");
        } else {
            return array("status" => 0, "message" => "Letter content saving was unsuccessful");
        }
    }

    public function letter_status_change($status, $id)
    {
        $status_change = Letter::find($id);
        $status_change->status = $status;
        $status_change->save();
        if ($status_change == true) {
            return array("status" => 1, "message" => "Letter status changed successfully");
        } else {
            return array("status" => 0, "message" => "Letter status change was unsuccessful");
        }
    }

    public function createLetterTemplate(Request $request)
    {
        $create_let_temp = LetterTemplate::create([
            "template_name" => $request->template_name,
            "created_by" => Auth::user()->id,
        ]);
        if ($create_let_temp == true) {
            return array("status" => 1, "message" => "Letter template created successfully");
        } else {
            return array("status" => 0, "message" => "Letter template creation was unsuccessful");
        }
    }

    public function updateLetterTemplate(Request $request)
    {
        $update_let_temp = LetterTemplate::find($request->template_id);
        $update_let_temp->template_name = $request->template_name;
        $update_let_temp->content = $request->template_content;
        $update_let_temp->created_by = Auth::user()->id;
        $update_let_temp->save();
        if ($update_let_temp == true) {
            return array("status" => 1, "message" => "Letter template updated successfully");
        } else {
            return array("status" => 0, "message" => "Letter template updation was unsuccessful");
        }
    }

    public function letterTemplatePage()
    {
        return view('letter_template');
    }

    public function loadTemplates(){
        $templates = LetterTemplate::all();
        return $templates;
    }

    public function letterTempById($id){
        $template = LetterTemplate::find($id);
        return view('letter_template', compact('template'));
    }
}
