<?php

namespace App\Http\Controllers;

use App\Committee;
use Illuminate\Http\Request;
use App\Repositories\CommitteeRepository;

class CommitteeController extends Controller
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
    public function index()
    {
        return  $this->committeeRepository->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|string',
            'site_clearence_session_id' => 'required|integer',
            'remark' => 'nullable|string',
            'schedule_date' => 'nullable|date',
        ]);
        if ($this->committeeRepository->create($request)) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->committeeRepository->show($id);
    }
    public function attribute($attribute, $value)
    {
        return $this->committeeRepository->getByAttribute($attribute, $value);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function edit(Committee $committee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'sometimes|required|string',
            'remark' => 'nullable|string',
            'schedule_date' => 'nullable|date',
        ]);
        if ($this->committeeRepository->update($request, $id)) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->committeeRepository->delete($id)) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }
}
