<?php

namespace App\Http\Controllers;

use App\Repositories\FileLogRepository;
use Codedge\Fpdf\Fpdf\Fpdf as Fpdf;
use Illuminate\Http\Request;

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

        $fpdf =  new Fpdf('l', 'mm', 'A3');
        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->Cell(50, 25, 'Site Clearence Application');
        $fpdf->Output();
        exit;
    }
}
