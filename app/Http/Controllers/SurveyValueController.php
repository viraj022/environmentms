<?php

namespace App\Http\Controllers;

use App\surveyValue;
use Illuminate\Http\Request;

class SurveyValueController extends Controller
{
    public function index()
    {

    }

    public function all($id)
    {
        return surveyValue::where('suray_param_attributes_id', $id)->get();
    }

    public function find($id)
    {
        return surveyValue::find($id);
    }

    public function create()
    {
        $surveyValue = new surveyValue();
        $surveyValue->name = \request('survey_value_name');
        $surveyValue->suray_param_attributes_id = \request('suray_param_attributes_id');

        $msg = $surveyValue->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function update($id)
    {
        $surveyValue = surveyValue::find($id);
        $surveyValue->name = \request('survey_value_name');
        $surveyValue->suray_param_attributes_id = \request('suray_param_attributes_id');

        $msg = $surveyValue->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function delete($id)
    {
        try {
            $surveyValue = surveyValue::find($id);
            $msg = $surveyValue->delete();
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

}
