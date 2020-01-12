<?php

namespace App\Http\Controllers;

use App\LocalAuthority;
use App\SurayParamAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Repositories\SurveyRepository;

class SurveyViewController extends Controller {

    private $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function province($id) {
        $aUser = Auth::user();
        $localAuthorities = LocalAuthority::where('provincial_council_id', $id)->get();
        $pageAuth = $aUser->authentication(config('auth.privileges.suboffice'));
        // return   $localAuthorities  ;
        return view('province_view', ['pageAuth' => $pageAuth, 'localAuthorities' => $localAuthorities]);
    }

    public function localAuthorty($id) {
        $aUser = Auth::user();
        $localAuthority = LocalAuthority::findOrFail($id);
        $pageAuth = $aUser->authentication(config('auth.privileges.suboffice'));
        
        $abc = $this->surveyRepository->getValuesTable()->toArray();

        $collection = [];
        $columns = [];

        foreach ($abc as $row) {
            if (!array_key_exists('title_' . $row['title_id'], $collection)) {
                $collection['title_' . $row['title_id']] = [
                    'title' => $row['titlle_name'],
                    'columns' => [],
                    'attr_rows' => []
                ];
            }

            $collection['title_' . $row['title_id']]['columns'][$row['param_id']] = $row['param_name'];

            // set first rows
            if (!array_key_exists('attr_' . $row['attr_id'], $collection['title_' . $row['title_id']]['attr_rows'])) {
                $collection['title_' . $row['title_id']]['attr_rows']['attr_' . $row['attr_id']] = [
                    'attr_name' => $row['attr_name'],
                    'attr_values' => []
                ];
            }

            $paramId = $row['param_id'];
            $paramValue = '';
            switch ($row['type']) {
                case 'DATE':
                    $paramValue = date('Y-m-d', strtotime($row['date']));
                    break;
                case 'SELECTED':
                    $paramValue = $row['text'];
                    break;
                case 'NUMERIC':
                    $paramValue = $row['number'];
                    break;                
                case 'TEXT':
                    $paramValue = $row['number'];
                    break;   
            }

            // column names
            $collection['title_' . $row['title_id']]['attr_rows']['attr_' . $row['attr_id']]['attr_values']['param_' . $paramId] = $paramValue;
        }

        $data = [
            'rows' => $collection
        ];

// return $data;

        return view('includes.table_values', compact('data', 'colsize'));
    }

}
