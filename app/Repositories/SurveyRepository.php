<?php

namespace App\Repositories;

use App\SurayParamAttribute;
use App\SurveyResult;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SurveyRepository
 *
 * @author viraj
 */
class SurveyRepository
{

    public function getTable($id)
    {
        return SurayParamAttribute::
            join('parameters', 'suray_param_attributes.parameter_id', '=', 'parameters.id') // add ,'left' if needed
            ->join('survey_attributes', 'suray_param_attributes.survey_attribute_id', '=', 'survey_attributes.id', 'right')
            ->where('survey_attributes.survey_title_id', $id)
            ->orderBy('survey_attributes.id', 'asc')
            ->select('survey_attributes.name AS attr_name', 'parameters.name AS para_name', 'suray_param_attributes.type', 'survey_attributes.id AS attr_id')
            ->get();
    }

    public function getValuesTable()
    {
        return SurveyResult::join('suray_param_attributes', 'survey_results.suray_param_attribute_id', '=', 'suray_param_attributes.id')
            ->join('parameters', 'suray_param_attributes.parameter_id', '=', 'parameters.id')
            ->join('survey_titles', 'parameters.titleId', '=', 'survey_titles.id')
            ->join('survey_attributes', 'suray_param_attributes.survey_attribute_id', '=', 'survey_attributes.id')
            ->orderBy('suray_param_attributes.id', 'asc')
            ->select('survey_results.suray_param_attribute_id', 'survey_results.text', 'survey_results.date', 'survey_results.number', 'suray_param_attributes.type', 'parameters.name AS param_name', 'parameters.id AS param_id', 'survey_titles.name AS titlle_name', 'survey_attributes.name AS attr_name', 'survey_attributes.id AS attr_id', 'survey_titles.id AS title_id')
            ->get();
    }

}
