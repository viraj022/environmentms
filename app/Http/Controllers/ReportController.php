<?php

namespace App\Http\Controllers;

use App\Repositories\FileLogRepository;
use App\Repositories\SiteClearenceRepository;
use Codedge\Fpdf\Fpdf\Fpdf as Fpdf;
use Illuminate\Http\Request;
use App\Reports\ReportTemplate;
use ReportTemplate as GlobalReportTemplate;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function getFileLog($client_id)
    {
        $fileLogRepository  = new FileLogRepository();
        return $fileLogRepository->getFIleLogById($client_id);
    }

    public function siteClearanceApplicationReport()
    {
        $site =   new SiteClearenceRepository();
        $data = $site->getSiteClearenceReport('2010-01-01', '2021-01-01', 'All')->toArray();
        // dd($data);
        $header = array('Date', 'File No', 'Name and Address', 'Industry Category');
        $fpdf =  new ReportTemplate('l', 'mm', 'A3', 'Site Clearence Application');
        $fpdf->AddPage();
        $fpdf->SetFont('Times', '', 12);

        if ($data) {
            $fpdf->ImprovedTable($header, $data);
        } else {
        }
        $fpdf->Output();
        exit;
    }
}
