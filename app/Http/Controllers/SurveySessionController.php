<?php

namespace App\Http\Controllers;

use App\SurveySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveySessionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SurveySession::with('surveyTitles')->get();
    }
    public function load()
    {
        $aUser = Auth::user();
        $pageAuth = $aUser->authentication(config('auth.privileges.dumpsite'));
        return view('survey_sessionStart', ['pageAuth' => $pageAuth]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->validate([
            'name' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'end_date' => ['required', 'date'],
        ]);
        \DB::transaction(function () {
            $surveySession = new SurveySession();
            $surveySession->name = request('name');
            $surveySession->start_date = request('start_date');
            $surveySession->year = request('year');
            $surveySession->end_date = request('end_date');
            $surveySession->save();
            foreach (request('titles') as $value) {
                // echo "$value";
                $surveySession->surveyTitles()->attach(
                    $value);

            }
        });
        return array('id' => '1', 'msg' => 'true');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SurveySession  $surveySession
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return SurveySession::Join('survey_session_survey_title', 'survey_sessions.id', '=', 'survey_session_survey_title.survey_session_id')
            ->join('survey_titles', 'survey_session_survey_title.survey_title_id', '=', 'survey_titles.id')
            ->where('survey_sessions.id', $id)
            ->select('survey_titles.name as title_name', 'survey_titles.id as title_id')
            ->get();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SurveySession  $surveySession
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveySession  $surveySession
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        request()->validate([
            'name' => ['required', 'string'],
        ]);

        $surveySession = SurveySession::findOrFail($id);
        $surveySession->name = request('name');
        $msg = $surveySession->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveySession  $surveySession
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $surveySession = SurveySession::findOrFail($id);
            $msg = $surveySession->delete();
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

    public function start($id)
    {

        $surveySession = SurveySession::findOrFail($id);
        $surveySession->session_status = 1;
        $msg = $surveySession->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }

    }
    public function end($id)
    {

        $surveySession = SurveySession::findOrFail($id);
        $surveySession->session_status = 2;
        $msg = $surveySession->save();
        if ($msg) {
            return array('id' => 1, 'mgs' => 'true');
        } else {
            return array('id' => 0, 'mgs' => 'false');
        }

    }
}
