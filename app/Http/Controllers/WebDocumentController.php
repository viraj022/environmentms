<?php

namespace App\Http\Controllers;

use App\Letter;

use Illuminate\Http\Request;

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

        if ($validated) {
            $save_letter_content = Letter::create([
                "letter_title" => $request->title,
                "complain_id" => $request->complain_id,
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
        return view('document_maker', compact('letter_title', 'id', 'letter_content'));
    }

    public function update_letter_content(Request $request)
    {

        $validated = $request->validate([
            'complain_id' => 'required',
            'content' => 'required',
        ]);

        if ($validated) {
            $update_letter_content = Letter::find($request->complain_id);
            $update_letter_content->letter_title = $request->letter_title;
            $update_letter_content->letter_content = $request->content;
            $status = $update_letter_content->save();
        }

        if ($status == true) {
            return array("status" => 1, "message" => "Letter content saved successfully");
        } else {
            return array("status" => 0, "message" => "Letter content saving was unsuccessful");
        }
    }
}
