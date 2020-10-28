<?php

namespace App\ReportTemplate;

use Codedge\Fpdf\Fpdf\Fpdf as Fpdf;
use Carbon\Carbon;

class ReportTemplateMultiCell extends FPDF
{
    private $widths;
    var $aligns;
    private $reportTitle;
    public $headers;

    function __construct($oriantation, $unit, $size, $reportTitle, $headers, $widths)
    {
        parent::__construct($oriantation, $unit, $size);
        $this->reportTitle = $reportTitle;
        $this->SetAuthor('Ceytech System Solutions');
        $this->headers = $headers;
        $this->widths = $widths;
    }
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function Header()
    {

        $this->SetFont('Times', 'B', 24);
        $this->Cell(0, 20, $this->reportTitle, '0', '1', 'C');
        $this->SetFontSize(20);
        $this->Cell(0, 5, 'Central Environment Authority - North Western Province', '0', '1', 'C');
        $this->Ln();
        $this->SetFontSize(14);
        $i = 0;
        foreach ($this->headers as $header)
            $this->Cell($this->widths[$i++], 10, $header, 1, 0, 'C');
        $this->Ln();
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
        $this->Cell(0, 10, 'Printed On : ' . $mytime->format('d-m-Y'), 0, 0, 'C');
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}
