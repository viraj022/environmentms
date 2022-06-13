<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function siteInspectionReportView()
    {
        return view('Reports.site_inspection_report');
    }
}
