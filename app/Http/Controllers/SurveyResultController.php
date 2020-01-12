<?php

namespace App\Http\Controllers;

use App\SurveyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyResultController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'local']);
    }
    public function all($id)
    {
        return SurveyResult::where('suray_param_attribute_id', $id)->get();
    }
    public function find($id)
    {
        return SurveyResult::find($id);
    }

    public function create()
    {
        \DB::transaction(function () {
            $aUser = Auth::user();
            $data = request('data');
            $msg = true;
            foreach ($data as $value) {
                $surveyResult = new SurveyResult();
                $surveyResult->survey_session_id = request('survey_session_id');
                $surveyResult->local_authority_id = $aUser->institute_Id;
                $surveyResult->suray_param_attribute_id = $value['suray_param_attribute_id'];
                switch ($value['type']) {
                    case 'DATE':
                        $surveyResult->date = $value['value'];
                        break;
                    case 'NUMERIC':
                        $surveyResult->number = $value['value'];
                        break;
                    default:
                        $surveyResult->text = $value['value'];
                        break;
                }
                $surveyResult->save();
            }
        });
        return array('id' => 1, 'mgs' => 'true');
    }

    public function update($id)
    {
        $surveyResult = SurveyResult::find($id);
        switch (\request('type')) {
            case 'TEXT':
                $surveyResult->text = \request('value');
                break;
            case 'DATE':
                $surveyResult->date = \request('value');
                break;
            case 'NUMERIC':
                $surveyResult->number = \request('value');
                break;
        }
        $msg = $surveyResult->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }
    }

    public function delete($id)
    {
        try {
            $surveyResult = SurveyResult::find($id);
            $msg = $surveyResult->delete();
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
