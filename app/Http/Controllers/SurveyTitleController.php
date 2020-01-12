<?php

namespace App\Http\Controllers;

use App\SurveySession;
use App\surveyTitle;
use Illuminate\Http\Request;

class SurveyTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show()
    {
        return view('survey_setup');
    }
    public function view($id)
    {
        $surveySession = SurveySession::findOrFail($id);
        return view('survey_view', ['surveySession' => $surveySession]);
    }

    public function index()
    {
        return surveyTitle::orderBy('order')->get();
    }

    public function find($id)
    {
        return surveyTitle::find($id);
    }

    public function create()
    {
        //        request()->validate([
        //            'survey_title_name' => 'required|max:150|regex:/^[\pL\s\-]+$/u',
        //            'survey_title_status' => 'nullable|max:50|integer',
        //        ]);
        $surveyTile = new surveyTitle();
        $surveyTile->name = request('survey_title_name');
        $surveyTile->status = request('survey_title_status');
        $msg = $surveyTile->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function update($id)
    {
        //        request()->validate([
        //            'survey_title_name' => 'required|max:150|regex:/^[\pL\s\-]+$/u',
        //            'survey_title_status' => 'nullable|max:50|integer',
        //        ]);

        $surveyTile = surveyTitle::find($id);
        $surveyTile->name = request('survey_title_name');
        $surveyTile->status = request('survey_title_status');
        $msg = $surveyTile->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function delete($id)
    {
        try {
            $surveyTile = surveyTitle::find($id);
            if ($surveyTile->surveyAttributes->count()) {
                return array('id' => 3, 'mgs' => 'SurveyAttributes');
            }
            if ($surveyTile->parameters->count()) {
                return array('id' => 3, 'mgs' => 'Parameter');
            }

            $msg = $surveyTile->delete();
            if ($msg) {
                return array('id' => 1, 'mgs' => 'true');
            } else {
                return array('id' => 0, 'mgs' => 'false');
            }
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->errorInfo[0] == 23000) {
                return response(array('id' => 3, 'mgs' => 'Cannot delete foreign key constraint fails'), 200)
                    ->header('Content-Type', 'application/json');

            } else {
                return response(array('id' => 3, 'mgs' => 'Internal Server Error'), 500)
                    ->header('Content-Type', 'application/json');

            }

        }
    }

    public function attributes($id)
    {
        $surveyTile = surveyTitle::find($id);
        return $surveyTile->surveyAttributes;
    }

    public function updateOrder()
    {
        foreach (request('order') as $value) {
            $surveyTile = surveyTitle::findOrFail($value['titleID']);
            $surveyTile->order = $value['order'];
            $surveyTile->save();
        }
        return array('id' => 1, 'mgs' => 'true');

    }
}
