<?php

namespace App\Http\Controllers;

use App\InspectionSession;
use Auth;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function siteInspectionReportView($id)
    {
        $inspectionSession = InspectionSession::with('client', 'inspection_interviewers', 'inspectionPersonals', 'environmentOfficer', 'environmentOfficer.user')->find($id);
        return view('Reports.site_inspection_report', ['inspectionSession' => $inspectionSession]);
    }
}
