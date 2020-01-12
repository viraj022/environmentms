<?php

namespace App\Http\Controllers;

use App\surveyAttribute;
use Illuminate\Http\Request;

class SurveyAttributeController extends Controller
{

    public function index()
    {

    }

    public function all()
    {
        return surveyAttribute::orderBy('order')->get();
    }
    public function title($id)
    {
        return surveyAttribute::where('survey_title_id', $id)->orderBy('order')->get();
    }

    public function find($id)
    {
        return surveyAttribute::find($id);
    }

    public function create()
    {
        $surveyAttribute = new surveyAttribute();
        $surveyAttribute->name = \request('survey_attribute_name');
        $surveyAttribute->survey_title_id = \request('survey_title_id');
        $msg = $surveyAttribute->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function update($id)
    {
        $surveyAttribute = surveyAttribute::find($id);
        $surveyAttribute->name = \request('survey_attribute_name');
        $surveyAttribute->survey_title_id = \request('survey_title_id');
        $msg = $surveyAttribute->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function delete($id)
    {
        try {
            $surveyAttribute = surveyAttribute::find($id);
            $msg = $surveyAttribute->delete();
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
    public function updateOrder()
    {
        foreach (request('order') as $value) {
            $surveyAttribute = surveyAttribute::findOrFail($value['attributeID']);
            $surveyAttribute->order = $value['order'];
            $surveyAttribute->save();
        }
        return array('id' => 1, 'mgs' => 'true');

    }

}
