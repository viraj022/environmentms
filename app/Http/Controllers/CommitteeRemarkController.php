<?php

namespace App\Http\Controllers;

use App\Committee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CommitteeRepository;

class CommitteeRemarkController extends Controller
{

    private  $committeeRepository;

    public function __construct(CommitteeRepository $committeeRepository)
    {
        $this->middleware(['auth:api']);
        $this->committeeRepository = $committeeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return  $this->committeeRepository->getRemarkByCommittee($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $committee)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.zone'));
        request()->validate([
            'remark' => 'sometimes|required|string',
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf',
        ]);
        $requestData = $request->all();
        $requestData['user_id'] =  $user->id;
        $requestData['committee_id'] = $committee;
        if ($request->has('file')) {
            $file = $request->file('file');
            $extension = $request->file->extension();
        } else {
            $file = null;
            $extension = null;
        }
        if ($this->committeeRepository->saveRemarksByCommittee($committee, $requestData, $file, $extension)) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->committeeRepository->showRemark($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort('404', "Update not available in this version");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($committee)
    {
        if ($this->committeeRepository->deleteRemarksByCommittee($committee)) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }
}
