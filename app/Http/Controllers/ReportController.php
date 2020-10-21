<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ReportTemplate\ReportTemplateMultiCell;
use App\Repositories\EPLRepository;
use App\Repositories\FileLogRepository;
use App\Repositories\SiteClearenceRepository;

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

    // public function siteClearanceApplicationReport()
    // {
    //     $site =   new SiteClearenceRepository();
    //     $result = $site->getSiteClearenceReport('2010-01-01', '2021-01-01', 'All')->toArray();
    //     // dd($result);

    //     $data = [];
    //     $num = 0;
    //     foreach ($result as $row) {
    //         $array = [];
    //         $array[] = ++$num;
    //         $array[] = Carbon::parse($row['submit_date'])->format('d-m-Y');
    //         $array[] = $row['code'];
    //         $array[] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'] . '\r\n' . $row['address'];
    //         $array[] = $row['category_name'];
    //         $array[] = $row['industry_address'];
    //         $array[] = $row['amount'] . ' ' . $row['invoice_no'] . ' ' . Carbon::parse($row['billed_at'])->format('d-m-Y');
    //         $array[] = $row['issue_date'];
    //         array_push($data, $array);
    //     }
    //     // dd($data);

    //     $fpdf =  new ReportTemplate('l', 'mm', 'A3', 'Site Clearence Application');
    //     $fpdf->AddPage();
    //     $fpdf->SetFont('Times', '', 12);

    //     if ($result) {
    //         $fpdf->headers =  ['#', 'Date', 'File Number', 'Applications Name and Address', 'Industry', "Location", 'Inspection Feee', "SC Certificate Issued Date"];
    //         $fpdf->widths =  [10, 30, 60, 70,  50,  50, 50,  50];
    //         $fpdf->data =  $data;
    //         $fpdf->ImprovedTable();
    //     } else {
    //     }
    //     $fpdf->Output();
    //     exit;
    // }
    public function siteClearanceApplicationReport()
    {
        $headers =  ['#', 'Date', 'File Number', 'Applications Name and Address', 'Industry', "Location", 'Inspection Feee', "Letter Issued Date"];
        $width = ([10, 30, 60, 70,  50,  50, 50,  50]);
        $pdf = new ReportTemplateMultiCell('l', 'mm', 'A3', 'Site Clearence Application', $headers, $width);
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 14);
        //Table with 20 rows and 4 columns
        $site =   new SiteClearenceRepository();
        $result = $site->getSiteClearenceReport('2010-01-01', '2021-01-01', 'All')->toArray();
        $num = 0;
        foreach ($result as $row) {
            $array = [];
            $array[] = ++$num;
            $array[] = Carbon::parse($row['submit_date'])->format('d-m-Y');
            $array[] = $row['code'];
            $array[] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'] . "\n" . $row['address'];
            $array[] = $row['category_name'];
            $array[] = $row['industry_address'];
            $array[] = 'Fee : ' . $row['amount'] . ' ' . "\nInvoice No : " . $row['invoice_no'] . "\nDate : " . Carbon::parse($row['billed_at'])->format('Y-m-d');
            $array[] = $row['issue_date'];
            $pdf->Row($array);
        }
        $pdf->Output();
    }
    public function siteClearanceApplicationReportBeta()
    {
        $site =   new SiteClearenceRepository();
        $result = $site->getSiteClearenceReport('2010-01-01', '2021-01-01', 'All')->toArray();
        $data = [];
        $num = 0;
        foreach ($result as $row) {
            $array = [];
            $array[] = ++$num;
            $array[] = Carbon::parse($row['submit_date'])->format('d-m-Y');
            $array[] = $row['code'];
            $array[] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'] . "\n" . $row['address'];
            $array[] = $row['category_name'];
            $array[] = $row['industry_address'];
            $array[] = 'Fee : ' . $row['amount'] . ' ' . "\nInvoice No : " . $row['invoice_no'] . "\nDate : " . Carbon::parse($row['billed_at'])->format('Y-m-d');
            $array[] = $row['issue_date'];
            array_push($data, $array);
        }
        return view('Reports.site_clearence_report', ['data' => $data]);
    }

    public function eplApplicationReport()
    {
        $epls =   new EPLRepository();
        $result =  $epls->getEPLReport('2010-01-01', '2021-01-01')->toArray();
        // dd($epls->getEPLReport('2010-01-01', '2021-01-01')->toArray()[0]);
        $data = [];
        $data['header_count'] = 0;
        $data['results'] = [];
        $num = 0;
        foreach ($result as $row) {
            // dd($row['epls']);
            $array = [];
            $array['#'] = ++$num;
            $array['submitted_date'] = Carbon::parse($row['epls'][0]['submitted_date'])->format('d-m-Y');
            $array['code'] = $row['epls'][0]['code'];
            $array['name_title'] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'] . "\n" . $row['address'];
            $array['category_name'] = $row['category_name'];
            $array['industry_address'] = $row['industry_address'];
            if (count($row['transactions']) > 0 && count($row['transactions'][0]['transaction_items']) > 0) {
                $array['inspection_fee'] = $row['transactions'][0]['transaction_items'][0]['amount'];
                $array['inspection_pay_date'] = Carbon::parse($row['transactions'][0]['billed_at'])->format('d-m-Y');
            } else {
                $array['inspection_fee'] = "N/A";
                $array['inspection_pay_date'] = "N/A";
            }
            if (count($row['site_clearence_sessions']) > 0) {
                $array['site_code'] = $row['site_clearence_sessions'][0]['code'];
            } else {
                $array['site_code'] = "N/A";
            }
            $array['epls'] = $row['epls'];
            if ($data['header_count'] < count($row['epls'])) {
                $data['header_count'] = count($row['epls']);
            }
            array_push($data['results'], $array);
        }
        // dd($data);
        return view('Reports.epl_report', ['data' => $data]);
    }

    public function eplApplicationLog()
    {
        $epls =   new EPLRepository();
        $result =  $epls->getEPLReport('2010-01-01', '2021-01-01')->toArray();
        $data = [];
        $num = 0;
        foreach ($result as $row) {
            // dd($row['epls']);
            $array = [];
            $array['#'] = ++$num;
            $array['submitted_date'] = Carbon::parse($row['epls'][0]['submitted_date'])->format('d-m-Y');
            $array['code'] = $row['epls'][0]['code'];
            $array['name_title'] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'] . "\n" . $row['address'];
            $array['category_name'] = $row['category_name'];
            $array['industry_address'] = $row['industry_address'];
            if (count($row['site_clearence_sessions']) > 0) {
                $array['nature'] = "SC -> EPL";
            } else {
                $array['nature'] = "EPL";
            }

            array_push($data, $array);
        }
        // dd($data);
        return view('Reports.epl_application_log_report', ['data' => $data]);
    }

    public function monthlyProgress()
    {
        $epl =   new EPLRepository();
        $NewEpls = $epl->ReceivedPLCount('2019-01-01', '2022-01-01', 1);
        dd($count->toArray());
    }
}
