<?php

namespace App\Http\Controllers;

use App\InspectionSessionAttachment;
use Illuminate\Http\Request;

class InspectionSessionAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InspectionSessionAttachment $inspectionSessionAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionSessionAttachment $inspectionSessionAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InspectionSessionAttachment $inspectionSessionAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InspectionSessionAttachment  $inspectionSessionAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspectionSessionAttachment $inspectionSessionAttachment)
    {
        //
    }

    private function makeApplicationPath($id, $attachemntId)
    {
        if (!is_dir("uploads")) {
            //Create our directory if it does not exist
            mkdir("uploads");
        }
        if (!is_dir("uploads/EPL")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL");
        }
        if (!is_dir("uploads/EPL/" . $id)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id);
        }
        if (!is_dir("uploads/EPL/" . $id . "/inspections")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/inspections");
        }
        if (!is_dir("uploads/EPL/" . $id . "/inspections/" . $attachemntId)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/inspections/" . $attachemntId);
        }
        return "uploads/EPL/" . $id . "/inspections/" . $attachemntId . "/";
    }
}
