<?php

namespace App\Reports;

use Codedge\Fpdf\Fpdf\Fpdf as Fpdf;
use Carbon\Carbon;

class ReportTemplate extends FPDF
{
    private $reportTitle;
    private $currentPage;
    function __construct($oriantation, $unit, $size, $reportTitle)
    {
        parent::__construct($oriantation, $unit, $size);
        $this->reportTitle = $reportTitle;
        $this->currentPage = 0;
        $this->AliasNbPages();
        $this->SetTitle($reportTitle);
        $this->SetAuthor('Ceytech System Solutions');
    }
    function Header()
    {

        $this->SetFont('Times', 'B', 24);
        $this->Cell(0, 20, $this->reportTitle, '0', '1', 'C');
        $this->SetFontSize(20);
        $this->Cell(0, 5, 'Central Environment Authority - North Western Province', '0', '1', 'C');
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Times', 'I', 8);
        // Page number
        $this->Cell($this->GetPageWidth() - 30, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $mytime = Carbon::now();
        $this->Cell(0, 10, 'printed on ' . $mytime->format('d-m-Y'), 0, 0, 'C');
    }
    function AcceptPageBreak()
    {
        // $this->SetFontSize(20);
        // $this->Cell(0, 5, 'Page Break Condition Met', '0', '1', 'C');
        return true;
    }
    function ImprovedTable($header, $data)
    {
        $this->Ln(30);
        // Column widths
        $w = array(100, 100, 100, 100);
        // Header
        // for ($i = 0; $i < count($header); $i++)
        //     $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        // $this->Ln();
        // Data
        foreach ($data as $row) {
            if ($this->currentPage <  $this->PageNo()) {
                for ($i = 0; $i < count($header); $i++)
                    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
                $this->Ln();
                ++$this->currentPage;
            }
            $this->Cell($w[0], 12, $row['last_name'], 'LR');
            $this->Cell($w[1], 12, $row['industry_name'], 'LR');
            $this->Cell($w[2], 12, $this->PageNo(), 'LR', 0, 'R');
            $this->Cell($w[3], 12, $this->GetY(), 'LR', 0, 'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
