<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\SiteClearance;
use Carbon\CarbonPeriod;
use App\Repositories\EPLRepository;
use App\Repositories\FileLogRepository;
use App\Repositories\CommitteeRepository;
use App\Repositories\SiteClearenceRepository;
use App\ReportTemplate\ReportTemplateMultiCell;
use App\Repositories\InspectionSessionRepository;
use App\Repositories\AssistanceDirectorRepository;
use App\Repositories\ClientRepository;
use App\Repositories\EnvironmentOfficerRepository;
use App\Repositories\IndustryCategoryRepository;

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
    /**
     * DO NOT DELETE
     * fpdf multi cell report don not delete
     */
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
    /**
     * DO NOT DELETE
     * fpdf multi cell report don not delete
     */

    public function siteClearanceApplicationReport()
    {
        $start = microtime(true);
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
    public function siteClearanceApplicationReportBeta($from, $to, $type)
    {
        $start = microtime(true);
        $site =   new SiteClearenceRepository();
        $result = $site->getSiteClearenceReport($from, $to, $type)->toArray();
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
        switch ($type) {
            case  'all':
                $title = "Site Clearence Report (All)";
                break;
            case 'new':
                $title = "Site Clearence Report (New)";
                break;
            case 'extend':
                $title = "Site Clearence Report (Extend)";
                break;
            default:
                abort('404', 'Report Type Not Defined - Ceytech internal error log');
        }
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.site_clearence_report', ['data' => $data, 'time_elapsed_secs' => $time_elapsed_secs, 'title' => $title, 'from' => $from, 'to' => $to]);
    }

    public function eplApplicationReport($from, $to)
    {
        $start = microtime(true);
        $epls =   new EPLRepository();
        $result =  $epls->getEPLReport('2010-01-01', '2021-01-01')->toArray();
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
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.epl_report', ['data' => $data, 'time_elapsed_secs' => $time_elapsed_secs, 'from' => $from, 'to' => $to]);
    }

    public function eplApplicationLog($from, $to)
    {
        $start = microtime(true);
        $epls =   new EPLRepository();
        $result =  $epls->getEPLReport($from, $to)->toArray();
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
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.epl_application_log_report', ['data' => $data, 'time_elapsed_secs' => $time_elapsed_secs, 'from' => $from, 'to' => $to]);
    }

    public function monthlyProgress($from, $to)
    {
        // $from = $from;
        // $to = $to;
        $start = microtime(true);
        $result = [];
        $epl =   new EPLRepository();
        $site = new SiteClearenceRepository();
        $ass = new AssistanceDirectorRepository();
        $inspection = new InspectionSessionRepository();
        $committee = new CommitteeRepository();
        $assistanceDirectors = $ass->getAssistanceDirectorWithZones();
        /**
         * Received Section
         */
        $newEplCount = $epl->ReceivedPLCount($from, $to, 1);
        $renewEplCount = $epl->ReceivedPLCount($from, $to, 0);
        $siteNewCount = $site->ReceivedSiteCount($from, $to, 1);
        $siteExtendCount = $site->ReceivedSiteCount($from, $to, 0);

        $result[] = array('type' => 'received', 'name' => 'SC(New)', 'application' => $this->prepareApplicationTotal($siteNewCount->toArray()), 'object' => $this->prepareCount($siteNewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'received', 'name' => 'SC(R)', 'application' => $this->prepareApplicationTotal($siteExtendCount->toArray()), 'object' => $this->prepareCount($siteExtendCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'received', 'name' => 'EPL(New)', 'application' => $this->prepareApplicationTotal($newEplCount->toArray()), 'object' => $this->prepareCount($newEplCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'received', 'name' => 'EPL(R)', 'application' => $this->prepareApplicationTotal($renewEplCount->toArray()), 'object' => $this->prepareCount($renewEplCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'received', 'name' => 'Agrarian Services', 'application' => $this->prepareApplicationTotal(array(), false), 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'received', 'name' => 'Land Lease Out', 'application' => $this->prepareApplicationTotal(array(), false), 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'received', 'name' => 'Court Case', 'application' => $this->prepareApplicationTotal(array(), false), 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'received', 'name' => 'Complaints', 'application' => $this->prepareApplicationTotal(array(), false), 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'received', 'name' => 'Other', 'application' => $this->prepareApplicationTotal(array(), false), 'object' => $this->prepareCount(array(), $assistanceDirectors, false));

        /**
         * Inspection Section
         */
        $eplInspectionNewCount = $inspection->getEPLInspection($from, $to, 1);
        $eplInspectionRenewCount = $inspection->getEPLInspection($from, $to, 0);
        $siteInspectionNewCount = $inspection->getSiteInspection($from, $to, 1);
        $siteInspectionRenewCount = $inspection->getSiteInspection($from, $to, 0);

        $totalCount = $this->generateTotalField(array(
            $eplInspectionNewCount,
            $eplInspectionRenewCount,
            $siteInspectionNewCount, $siteInspectionRenewCount
        ), $assistanceDirectors);
        // dd($siteInspectionNewCount->toArray(), $siteInspectionRenewCount->toArray());

        $result[] = array('type' => 'Inspection', 'name' => 'SC(New)', 'application' => "", 'object' => $this->prepareCount($siteInspectionNewCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Inspection', 'name' => 'SC(R)', 'application' => "", 'object' => $this->prepareCount($siteInspectionRenewCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Inspection', 'name' => 'EPL(New)', 'application' => "", 'object' => $this->prepareCount($eplInspectionNewCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Inspection', 'name' => 'EPL(R)', 'application' => '', 'object' => $this->prepareCount($eplInspectionRenewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'Inspection', 'name' => 'Total', 'application' => '', 'object' => $totalCount);
        $result[] = array('type' => 'Inspection', 'name' => 'Agrarian Services', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'Inspection', 'name' => 'Land Lease Out', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'Inspection', 'name' => 'Monitoring', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'Inspection', 'name' => 'Court Case', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'Inspection', 'name' => 'Complaints', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'Inspection', 'name' => 'Other', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));
        $result[] = array('type' => 'Inspection', 'name' => 'UnAuthorized', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));


        /**
         * Completed Section
         */

        $completedNewEplCount =   $epl->IssuedPLCount($from, $to, 1);
        $completedReNewEplCount =  $epl->IssuedPLCount($from, $to, 0);
        $completedNewSiteCount =   $site->IssuedSiteCount($from, $to, 1);
        $completedRenewSiteCount =    $site->IssuedSiteCount($from, $to, 0);
        $totalIssuedCount = $this->generateTotalField(array(
            $completedNewEplCount,
            $completedReNewEplCount,
            $completedNewSiteCount, $completedRenewSiteCount
        ), $assistanceDirectors);

        $result[] = array('type' => 'Issued', 'name' => 'SC(New)', 'application' => "", 'object' => $this->prepareCount($completedNewSiteCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Issued', 'name' => 'SC(R)', 'application' => "", 'object' => $this->prepareCount($completedRenewSiteCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Issued', 'name' => 'EPL(New)', 'application' => "", 'object' => $this->prepareCount($completedNewEplCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Issued', 'name' => 'EPL(R)', 'application' => '', 'object' => $this->prepareCount($completedReNewEplCount->toArray(), $assistanceDirectors));

        $result[] = array('type' => 'Issued', 'name' => 'Total', 'application' => '', 'object' => $totalIssuedCount);

        $result[] = array('type' => 'Issued', 'name' => 'Agrarian Services', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));

        $result[] = array('type' => 'Issued', 'name' => 'Land Lease Out', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));

        $result[] = array('type' => 'Issued', 'name' => 'Respond for Court Case', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));


        $result[] = array('type' => 'Issued', 'name' => 'Other Letters', 'application' => '', 'object' => $this->prepareCount(array(), $assistanceDirectors, false));


        /**
         * Rejected Section
         */

        $rejectedEplCount =    $epl->EPlPLCount($from, $to, 0, 2);
        $rejectedNewSiteCount =    $site->SiteCount($from, $to, 0, 2);

        $result[] = array('type' => 'Rejected', 'name' => 'SC', 'application' => "", 'object' => $this->prepareCount($rejectedNewSiteCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'Rejected', 'name' => 'EPL', 'application' => "", 'object' => $this->prepareCount($rejectedEplCount->toArray(), $assistanceDirectors));
        /**
         * Committee
         */
        $committeeCount = $committee->getCommitteeCount($from, $to);
        $result[] = array('type' => 'Technical Committee', 'name' => 'Meetings', 'application' => "", 'object' => $this->prepareCount($committeeCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => 'Technical Committee', 'name' => 'TOR Preparations', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => 'Technical Committee', 'name' => 'Letters', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        /**
         * Others
         */
        $telecommunicationCount =    $site->SiteCount($from, $to, -1, 0, SiteClearance::SITE_TELECOMMUNICATION);
        $towerEplNewCount = $epl->TowerEPlPLCount($from, $to, 1, 0);
        $towerEplRenewCount = $epl->TowerEPlPLCount($from, $to, 0, 0);
        // dd($towerEplNewCount);

        $result[] = array('type' => '', 'name' => 'Meeting/Test Blast', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Joint Inspection', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Trainings', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'SWML', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower (EPL R)', 'application'  => $this->prepareApplicationTotal($towerEplRenewCount->toArray()), 'object' => $this->prepareCount($towerEplRenewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower (EPL N)', 'application'  => $this->prepareApplicationTotal($telecommunicationCount->toArray()), 'object' => $this->prepareCount($towerEplNewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower SC', 'application' => $this->prepareApplicationTotal($telecommunicationCount->toArray()), 'object' => $this->prepareCount($telecommunicationCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Expert Committee Meetings', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        // dd($result);
        // dd($assistanceDirectors->toArray());
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($time_elapsed_secs);
        return view('Reports.monthly_progress_report', compact('result', 'assistanceDirectors', 'time_elapsed_secs', 'from', 'to'));
    }

    private function prepareCount($array, $assistanceDirectors, $flag = true)
    {
        $rtn = [];
        // dd($array);
        // dd($assistanceDirectors->toArray());
        foreach ($assistanceDirectors as $assistanceDirector) {
            if ($flag) {
                $data =  array('total' => 0);
            } else {
                $data =  array('total' => '');
            }
            foreach ($array as $a) {
                if ($assistanceDirector->id == $a['ass_id']) {
                    $data['total'] = $a['total'];
                }
            }
            array_push($rtn, $data);
        }
        return $rtn;
    }
    private function generateTotalField($array, $assistanceDirectors)
    {
        $rtn = [];
        // dd($array);
        // dd($assistanceDirectors->toArray());
        foreach ($assistanceDirectors as $assistanceDirector) {
            $data['total'] = 0;
            foreach ($array as $a) {
                foreach ($a as $d) {
                    if ($assistanceDirector->id == $d['ass_id']) {
                        $data['total'] = $data['total'] + $d['total'];
                    }
                }
            }
            array_push($rtn, $data);
        }
        return $rtn;
    }
    private function prepareApplicationTotal($array, $flag = true)
    {
        $rtn = 0;
        if (count($array) > 0) {

            foreach ($array as $a) {
                $rtn = $rtn + $a['total'];
            }
        }
        if ($flag) {

            return $rtn;
        } else {
            return '';
        }
    }
    public function eoInspectionReport($eo_id, $from, $to)
    {
        $start = microtime(true);
        $inspection = new InspectionSessionRepository();
        $env = new EnvironmentOfficerRepository();
        $rows = [];
        $environmentOfficer = $env->getOfficerDetails($eo_id);
        $data =  $inspection->getSiteInspectionDetails($from, $to, $environmentOfficer->id);
        // dd($data->toArray());

        $period = CarbonPeriod::create($from, $to);

        foreach ($period as $date) {
            $dateFormatted = $date->format('Y-m-d');
            $row = array(
                "Date" =>  $dateFormatted,
                "location" => [],
                "pradesheeyasaba" => [],
                "file_no" => [],
                "distance" => '',
            );

            foreach ($data->toArray()  as $d) {
                // echo $d['completed_at'] . " " . $dateFormatted . "<br>";
                if ($d['completed_at'] == $dateFormatted) {
                    array_push($row['location'], $d['industry_address']);
                    array_push($row['pradesheeyasaba'], $d['pradesheeyasaba_name']);
                    array_push($row['file_no'], $d['code']);
                }
            }
            $row['location'] =    array_unique($row['location'], SORT_STRING);
            $row['pradesheeyasaba'] =  array_unique($row['pradesheeyasaba'], SORT_STRING);
            $row['file_no'] =   array_unique($row['file_no'], SORT_STRING);

            $row['location'] =    implode(".\r\n", $row['location']);
            $row['pradesheeyasaba'] =  implode(",\r\n", $row['pradesheeyasaba']);
            $row['file_no'] =   implode(",\r\n", $row['file_no']);

            array_push($rows, $row);
        }

        // Convert the period to an array of dates
        // $dates = $period->toArray();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($rows, $time_elapsed_secs);
        return view('Reports.eo_inspection_monthly_report', compact('rows', 'environmentOfficer', 'time_elapsed_secs', 'from', 'to'));
    }
    public function categoryWiseCountReport($from, $to)
    {
        $start = microtime(true);
        $rows = [];
        $client = new ClientRepository();
        $categoryRepo = new IndustryCategoryRepository();
        $data = $client->allPlain($from, $to);
        foreach ($categoryRepo->all() as $category) {
            $row = array(
                "name" => $category->name,
                "sc_new" => 0,
                "sc_extend" => 0,
                "epl_new" => 0,
                "epl_renew" => 0,
                "certificates" => 0,
            );
            $siteNew =  $data->where('industry_category_id', $category->id)
                ->whereBetween('site_submit_date', [$from, $to])
                ->where('site_count', 0)->count();
            $siteExtend =  $data->where('industry_category_id', $category->id)
                ->whereBetween('site_submit_date', [$from, $to])
                ->where('site_count', '>', 0)->count();
            $eplNew = $data->where('industry_category_id', $category->id)
                ->whereBetween('epl_submitted_date', [$from, $to])
                ->where('epl_count', 0)->count();
            $eplRenew = $data->where('industry_category_id', $category->id)
                ->whereBetween('epl_submitted_date', [$from, $to])
                ->where('epl_count', '>', 0)->count();

            $eplCertificate = $data->where('industry_category_id', $category->id)
                ->whereBetween('epl_issue_date', [$from, $to])->count();
            $siteCertificate = $data->where('industry_category_id', $category->id)
                ->whereBetween('site_issue_date', [$from, $to])->count();

            $row['sc_new'] = $siteNew;
            $row['sc_extend'] = $siteExtend;
            $row['epl_new'] = $eplNew;
            $row['epl_renew'] = $eplRenew;
            $row['certificates'] = $eplCertificate + $siteCertificate;
            array_push($rows, $row);
        }
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($rows, $time_elapsed_secs);
        return view('Reports.category_wise_count_report', compact('rows', 'time_elapsed_secs', 'from', 'to'));
    }
}
