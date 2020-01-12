<?php

namespace App\Http\Controllers;

use App\Repositories\SurveyRepository;
use App\SurayParamAttribute;
use Illuminate\Http\Request;

class SurayParamAttributeController extends Controller
{

    private $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function all()
    {
        return SurayParamAttribute::all();
    }

    public function find($id)
    {
        return SurayParamAttribute::find($id);
    }

    public function create()
    {
        $surveyAttribute = new SurayParamAttribute();
        $surveyAttribute->parameter_id = \request('survey_parameter_id');
        $surveyAttribute->survey_attribute_id = \request('survey_attribute_id');
        $surveyAttribute->type = \request('type');

        $msg = $surveyAttribute->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function update($id)
    {

        $surveyAttribute = SurayParamAttribute::find($id);
        $surveyAttribute->parameter_id = \request('survey_parameter_id');
        $surveyAttribute->survey_attribute_id = \request('survey_attribute_id');
        $surveyAttribute->type = \request('type');

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
            $surveyAttribute = SurayParamAttribute::find($id);
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

    public function types()
    {
        return array("SELECTED" => SurayParamAttribute::SELECTED, "TEXT" => SurayParamAttribute::TEXT, "DATE" => SurayParamAttribute::DATE, "NUMERIC" => SurayParamAttribute::NUMERIC);
    }

    public function values($id)
    {
        return SurayParamAttribute::join('parameters', 'suray_param_attributes.parameter_id', '=', 'parameters.id')->where('survey_attribute_id', $id)->get();
    }

    public function ids($parameter_id, $attribute_id)
    {
        return SurayParamAttribute::where('parameter_id', $parameter_id)->where('survey_attribute_id', $attribute_id)->get();
    }

    public function table($id)
    {
        $results = $this->surveyRepository->getTable($id);
        $tableRows = array();
        $tableParam = array();
        foreach ($results as $tr) {
            if ($tr['para_name'] != null) {
                if (!in_array($tr['para_name'], $tableParam)) {
                    $tableParam[] = $tr['para_name'];
                }
            }
            if (!array_key_exists($tr['attr_id'], $tableRows)) {
                $tableRows[$tr['attr_id']] = array('attr_name' => $tr['attr_name']);
            }
            $tableRows[$tr['attr_id']][$tr['para_name']] = $tr['type'];
        }
//        dump($tableRows);
        //        dump($tableParam);
        //        dump($results);
        //        dd($tableRows);
        return view('includes.table', ['tableRows' => $tableRows, 'tableParam' => $tableParam]);
    }

    public function assigned($id)
    {
        // 'Hi';
        return SurayParamAttribute::Join('parameters', 'suray_param_attributes.parameter_id', '=', 'parameters.id')->where('survey_attribute_id', $id)
            ->select('parameters.name as param_name', 'suray_param_attributes.id', 'suray_param_attributes.type')
            ->get();
    }
    public function assignedOption($id)
    {
        // 'Hi';
        return SurayParamAttribute::With('surveyValues')->Join('parameters', 'suray_param_attributes.parameter_id', '=', 'parameters.id')->where('survey_attribute_id', $id)
            ->select('parameters.name as param_name', 'suray_param_attributes.id', 'suray_param_attributes.type')
            ->get();
    }
}
