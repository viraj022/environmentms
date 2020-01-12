<?php

namespace App\Http\Controllers;

use App\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    public function all()
    {
        return Parameter::all();
    }
    public function title($id)
    {
        return Parameter::where('titleID', $id)->get();
    }
    public function find($id)
    {
        return Parameter::find($id);
    }
    public function create()
    {
        $Parameter = new Parameter();
        $Parameter->name = \request('survey_parameter_name');
        $Parameter->titleId = \request('survey_title_id');
        $msg = $Parameter->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }
    public function update($id)
    {
        $Parameter = Parameter::find($id);
        $Parameter->name = \request('survey_parameter_name');
        $Parameter->titleId = \request('survey_title_id');
        $msg = $Parameter->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }
    public function delete($id)
    {
        try {
            $parameter = Parameter::find($id);
            $msg = $parameter->delete();
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
    public function assignedParameters($titleId, $attributeID)
    {
        $arrt = $attributeID;
        return Parameter::with('SurayParamAttributes')->wherehas('SurayParamAttributes', function ($queary) use ($attributeID) {
            $queary->where('survey_attribute_id', $attributeID);
        })->where('titleID', $titleId)->get();
    }

    public function doesntAssignedParameters($titleId, $attributeID)
    {
        $arrt = $attributeID;
        return Parameter::whereDoesntHave('SurayParamAttributes', function ($queary) use ($attributeID) {
            $queary->where('survey_attribute_id', $attributeID);
        })->where('titleID', $titleId)->get();
    }
}
