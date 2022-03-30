<?php

namespace App\ReportTemplate;

use Codedge\Fpdf\Fpdf\Fpdf as Fpdf;
use Carbon\Carbon;

class SummaryTemplate extends FPDF
{
    private $reportTitle;
    private $currentPage;
    public $headers;
    public $widths;
    public $data;

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
        $this->Cell(0, 5, $this->reportTitle, '0', '1', 'C');
        $this->SetFontSize(11);
        $this->Cell(0, 10, 'Provincial Environmental Authority - North Western Province', '0', '1', 'C');
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Times', 'I', 8);
        // Page number
        $this->Cell(40, 10, "    Powered by Ceytech System Solutions (037-2234005)", 0, 0, 'C');
        $this->Cell($this->GetPageWidth() - 100, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $mytime = Carbon::now();
        $this->Cell(0, 10, 'Printed On : ' . $mytime->format('d-m-Y'), 0, 0, 'C');
    }
    function AcceptPageBreak()
    {
        // $this->SetFontSize(20);
        // $this->Cell(0, 5, 'Page Break Condition Met', '0', '1', 'C');
        return true;
    }
    function ImprovedTable()
    {
        $this->Ln(30);
        // Column widths

        // Header
        $i = 0;
        foreach ($this->headers as $header)
            $this->Cell($this->widths[$i++], 10, $header, 1, 0, 'C');
        $this->Ln();
        // Data
        foreach ($this->data as $row) {
            $j = 0;
            foreach ($row as $cell) {
                // dd($cell);
                $this->Cell($this->widths[$j++], 20, $cell, 'LRB');
            }
            // $this->Cell($w[0], 12, $row['last_name'], 'LRB');
            // $this->Cell($w[1], 12, $row['industry_name'], 'LRB');
            // $this->Cell($w[2], 12, $this->PageNo(), 'LRB', 0, 'R');
            // $this->Cell($w[3], 12, $this->GetY(), 'LRB', 0, 'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($this->widths), 0, '', 'T');
    }
}
