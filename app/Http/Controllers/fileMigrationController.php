<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Client;
use App\CommitteeRemark;
use App\EPL;
use App\InspectionSessionAttachment;
use App\OldFiles;
use App\SiteClearance;
use Illuminate\Http\Request;

class fileMigrationController extends Controller
{
    // constructor
    public function __construct()
    {
        // $this->middleware('auth:api');
        // $this->fixCertificate();
    }

    // index
    public function index()
    {
        $this->fixSiteClearances();
        return view('file-migration');
    }

    // get old files
    public function getOldFiles()
    {
        $oldFiles = OldFiles::get();
        foreach ($oldFiles as $oldFile) {
            // if isset storage// and storage/ replace with empty string
            $oldFile->path = str_replace('storage//', '', $oldFile->path);
            //save changes
            $oldFile->save();
        }
        // return response
        return response()->json([
            'message' => 'Old files updated successfully',
            'status' => 'success',
        ], 200);
    }

    // Client table
    public function fixClient()
    {
        $client = Client::all();
        foreach ($client as $value) {
            if (isset($value->application_path)) {
                $value->application_path = str_replace('/uploads', 'uploads', $value->application_path);
            }

            if (isset($value->file_01)) {
                $value->file_01 = str_replace('/uploads', 'uploads', $value->file_01);
            }

            if (isset($value->file_02)) {
                $value->file_02 = str_replace('/uploads', 'uploads', $value->file_02);
            }

            if (isset($value->file_03)) {
                $value->file_03 = str_replace('/uploads', 'uploads', $value->file_03);
            }
            $value->save();
        }
        // return response
        return response()->json([
            'message' => 'Client updated successfully',
            'status' => 'success',
        ], 200);
    }

    // epl table
    function fixEpl()
    {
        $epls = EPL::withTrashed()->get();
        foreach ($epls as $e) {
            if (isset($e->path)) {
                $e->path = str_replace('/uploads', 'uploads', $e->path);
            }
            //application_path
            if (isset($e->application_path)) {
                $e->application_path = str_replace('/uploads', 'uploads', $e->application_path);
            }
            $e->save();
        }
        // return response
        return response()->json([
            'message' => 'EPL updated successfully',
            'status' => 'success',
        ], 200);
    }

    // site clearances table
    public function fixSiteClearances()
    {
        $siteClearances = SiteClearance::withTrashed()->get();
        foreach ($siteClearances as $value) {
            if (isset($value->application_path)) {
                $value->application_path = str_replace('/uploads', 'uploads', $value->application_path);
            }
            //certificate_path
            if (isset($value->certificate_path)) {
                $value->certificate_path = str_replace('/uploads', 'uploads', $value->certificate_path);
            }
            $value->save();
        }
        // return response
        return response()->json([
            'message' => 'SiteClearance updated successfully',
            'status' => 'success',
        ], 200);
    }

    //CommitteeRemark table
    public function fixCommitteeRemark()
    {
        $committeeRemarks = CommitteeRemark::all();
        foreach ($committeeRemarks as $value) {
            if (isset($value->path)) {
                $value->path = str_replace('/uploads', 'uploads', $value->path);
            }
            $value->save();
        }
        // return response
        return response()->json([
            'message' => 'CommitteeRemark updated successfully',
            'status' => 'success',
        ], 200);
    }

    // InspectionSessionAttachment table
    public function fixInspectionSessionAttachment()
    {
        $inspectionSessionAttachments = InspectionSessionAttachment::all();
        foreach ($inspectionSessionAttachments as $value) {
            if (isset($value->path)) {
                $value->path = str_replace('/uploads', 'uploads', $value->path);
            }
            $value->save();
        }
        // return response
        return response()->json([
            'message' => 'InspectionSessionAttachment updated successfully',
            'status' => 'success',
        ], 200);
    }

    // Certificate table
    public function fixCertificate()
    {
        $certificates = Certificate::withTrashed()->get();
        foreach ($certificates as $value) {
            if (isset($value->certificate_path)) {
                $value->certificate_path = str_replace('/uploads', 'uploads', $value->certificate_path);
            }

            if (isset($value->signed_certificate_path)) {
                $value->signed_certificate_path = str_replace('/uploads', 'uploads', $value->signed_certificate_path);
            }
            $value->save();
        }
        // return response
        return response()->json([
            'message' => 'Certificate updated successfully',
            'status' => 'success',
        ], 200);
    }
}
