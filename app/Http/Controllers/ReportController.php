<?php

namespace App\Http\Controllers;

use App\Client;
use Carbon\Carbon;
use App\SiteClearance;
use Carbon\CarbonPeriod;
use App\Repositories\EPLRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientRepository;
use App\ReportTemplate\SummaryTemplate;
use App\Repositories\FileLogRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CommitteeRepository;
use App\Repositories\SiteClearenceRepository;
use App\ReportTemplate\ReportTemplateMultiCell;
use App\Repositories\IndustryCategoryRepository;
use App\Repositories\InspectionSessionRepository;
use App\Repositories\AssistanceDirectorRepository;
use App\Repositories\EnvironmentOfficerRepository;
use App\Repositories\PradesheeyasabaRepository;
use PhpParser\Node\Expr\Print_;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('report_dashboard', ['pageAuth' => $pageAuth]);
    }

    public function getFileLog($client_id)
    {
        $fileLogRepository = new FileLogRepository();
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
        $headers = ['#', 'Date', 'File Number', 'Applications Name and Address', 'Industry', "Location", 'Inspection Feee', "Letter Issued Date"];
        $width = ([10, 30, 60, 70, 50, 50, 50, 50]);
        $pdf = new ReportTemplateMultiCell('l', 'mm', 'A3', 'Site Clearence Application', $headers, $width);
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 14);
        //Table with 20 rows and 4 columns
        $site = new SiteClearenceRepository();
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
        $site = new SiteClearenceRepository();
        $result = $site->getSiteClearenceReport($from, $to, $type)->toArray();
        $data = [];
        $num = 0;
        foreach ($result as $row) {
            $array = [];
            $array[] = ++$num;
            $array[] = Carbon::parse($row['submit_date'])->format('Y-m-d');
            $array[] = $row['code'];
            $array[] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'] . "\n" . $row['address'];
            $array[] = $row['category_name'];
            $array[] = $row['industry_address'];
            $array[] = 'Fee : ' . $row['amount'] . ' ' . "Invoice No : " . $row['invoice_no'] . "\nDate : " . Carbon::parse($row['billed_at'])->format('Y-m-d');
            $array[] = Carbon::parse($row['issue_date'])->format('Y-m-d');
            $array[] = Carbon::parse($row['created_at'])->format('Y-m-d');
            array_push($data, $array);
        }
        switch ($type) {
            case 'all':
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
        $epls = new EPLRepository();
        $result = $epls->getEPLReport($from, $to)->toArray();
        $data = [];
        $data['header_count'] = 0;
        $data['results'] = [];
        $num = 0;
        foreach ($result as $row) {
            // dd($row);
            $array = [];
            $array['#'] = ++$num;
            $array['submitted_date'] = Carbon::parse($row['submitted_date'])->format('Y-m-d');
            $array['issue_date'] = Carbon::parse($row['issue_date'])->format('Y-m-d');
            $array['created_at'] = Carbon::parse($row['created_at'])->format('Y-m-d');
            $array['code'] = $row['code'];
            $array['name_title'] = $row['client']['name_title'] . ' ' . $row['client']['first_name'] . ' ' . $row['client']['last_name'] . "\n" . $row['client']['address'];
            $array['category_name'] = $row['client']['industry_category']['name'];
            $array['industry_address'] = $row['client']['industry_address'];
            if (count($row['client']['transactions']) > 0 && count( $row['client']['transactions'][0]['transaction_items']) > 0) {
                $array['inspection_fee'] = $row['client']['transactions'][0]['transaction_items'][0]['amount'];
                $array['inspection_pay_date'] = Carbon::parse($row['client']['transactions'][0]['billed_at'])->format('Y-m-d');
            } else {
                $array['inspection_fee'] = "N/A";
                $array['inspection_pay_date'] = "N/A";
            }
            $array['license_number'] = $row['certificate_no'];
            array_push($data['results'], $array);
        }
        // dd($data);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.epl_report', ['data' => $data, 'time_elapsed_secs' => $time_elapsed_secs, 'from' => $from, 'to' => $to]);
    }

    public function eplApplicationLog($from, $to)
    {
        $start = microtime(true);
        $epls = new EPLRepository();
        $result = $epls->getEPLReport($from, $to)->toArray();
        $data = [];
        $num = 0;
        foreach ($result as $row) {
            // dd($row);
            $array = [];
            $array['#'] = ++$num;
            $array['submitted_date'] = Carbon::parse($row['submitted_date'])->format('d-m-Y');
            $array['code'] = $row['code'];
            $array['name_title'] = $row['client']['name_title'] . ' ' . $row['client']['first_name'] . ' ' . $row['client']['last_name'] . "\n" . $row['client']['address'];
            $array['category_name'] = $row['client']['industry_category']['name'];
            $array['industry_address'] = $row['client']['industry_address'];
            if (count($row['client']['site_clearence_sessions']) > 0) {
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
        $epl = new EPLRepository();
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
        $completedNewEplCount = $epl->IssuedPLCount($from, $to, 1);
        $completedReNewEplCount = $epl->IssuedPLCount($from, $to, 0);
        $completedNewSiteCount = $site->IssuedSiteCount($from, $to, 1);
        $completedRenewSiteCount = $site->IssuedSiteCount($from, $to, 0);
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
        $rejectedEplCount = $epl->EPlPLCount($from, $to, 0, 2);
        $rejectedNewSiteCount = $site->SiteCount($from, $to, 0, 2);

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
        $telecommunicationCount = $site->SiteCount($from, $to, -1, 0, SiteClearance::SITE_TELECOMMUNICATION);
        $towerEplNewCount = $epl->TowerEPlPLCount($from, $to, 1, 0);
        $towerEplRenewCount = $epl->TowerEPlPLCount($from, $to, 0, 0);
        // dd($towerEplNewCount);

        $result[] = array('type' => '', 'name' => 'Meeting/Test Blast', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Joint Inspection', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Trainings', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'SWML', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower (EPL R)', 'application' => $this->prepareApplicationTotal($towerEplRenewCount->toArray()), 'object' => $this->prepareCount($towerEplRenewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower (EPL N)', 'application' => $this->prepareApplicationTotal($telecommunicationCount->toArray()), 'object' => $this->prepareCount($towerEplNewCount->toArray(), $assistanceDirectors));
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
                $data = array('total' => 0);
            } else {
                $data = array('total' => '');
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
        $data = $inspection->getSiteInspectionDetails($from, $to, $environmentOfficer->id);
        // dd($data->toArray());

        $period = CarbonPeriod::create($from, $to);

        foreach ($period as $date) {
            $dateFormatted = $date->format('Y-m-d');
            $row = array(
                "Date" => $dateFormatted,
                "location" => [],
                "pradesheeyasaba" => [],
                "file_no" => [],
                "distance" => '',
            );

            foreach ($data->toArray() as $d) {
                // echo $d['completed_at'] . " " . $dateFormatted . "<br>";
                if ($d['completed_at'] == $dateFormatted) {
                    array_push($row['location'], $d['industry_address']);
                    array_push($row['pradesheeyasaba'], $d['pradesheeyasaba_name']);
                    array_push($row['file_no'], $d['code']);
                }
            }
            $row['location'] = array_unique($row['location'], SORT_STRING);
            $row['pradesheeyasaba'] = array_unique($row['pradesheeyasaba'], SORT_STRING);
            $row['file_no'] = array_unique($row['file_no'], SORT_STRING);

            $row['location'] = implode(".\r\n", $row['location']);
            $row['pradesheeyasaba'] = implode(",\r\n", $row['pradesheeyasaba']);
            $row['file_no'] = implode(",\r\n", $row['file_no']);

            array_push($rows, $row);
        }

        // Convert the period to an array of dates
        // $dates = $period->toArray();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($rows, $time_elapsed_secs);
        return view('Reports.eo_inspection_monthly_report', compact('rows', 'environmentOfficer', 'time_elapsed_secs', 'from', 'to'));
    }

    public function categoryLocalAuthorityWiseCountReport($from, $to)
    {
        $start = microtime(true);
        $categoryRepo = new IndustryCategoryRepository();
        $pradesheeyaRepo = new PradesheeyasabaRepository();
        $category = $categoryRepo->all()->keyBy('id')->toArray();
        $category = array_map(function ($cat) {
            return array(
                "name" => $cat['name'],
                "epl_new" => 0,
                "epl_renew" => 0,
                "site_new" => 0,
                "site_renew" => 0,
                "certificate_issue" => 0
            );
        }, $category);

        $la = $pradesheeyaRepo->all()->keyBy('id')->toArray();

        $la = array_map(function ($l) {
            return array(
                "name" => $l['name']
            );
        }, $la);
        $req_array = $la;

        foreach ($req_array as $key => $value) {
            $req_array[$key]['cat'] = $category;
        }

        $client = new ClientRepository();
        $EplNewCount = $client->fileCountByIndustryCategoryAndLocalAuthorityEPLNew($from, $to)->toArray();
        $EplRenewCount = $client->fileCountByIndustryCategoryAndLocalAuthorityEPLRevew($from, $to)->toArray();
        $EplIssueCount = $client->fileCountByIndustryCategoryAndLocalAuthorityEPLIssue($from, $to)->toArray();
        $SiteNewCount = $client->fileCountByIndustryCategoryAndLocalAuthoritySiteNew($from, $to)->toArray();
        $SiteRenewCount = $client->fileCountByIndustryCategoryAndLocalAuthoritySiteRevew($from, $to)->toArray();
        $SiteIsssueCount = $client->fileCountByIndustryCategoryAndLocalAuthoritySiteIssue($from, $to)->toArray();
        $data = array_merge($EplNewCount, $EplRenewCount, $EplIssueCount, $SiteNewCount, $SiteRenewCount, $SiteIsssueCount);

        foreach ($data as $key => $value) {

            switch ($value['type']) {
                case 'EPL_New':

                    $req_array[$value['la_id']]['cat'][$value['cat_id']]['epl_new'] += $value['total'];

                    break;
                case 'EPL_Renew':
                    $req_array[$value['la_id']]['cat'][$value['cat_id']]['epl_renew'] += $value['total'];

                    break;
                case 'Site_New':
                    $req_array[$value['la_id']]['cat'][$value['cat_id']]['site_new'] += $value['total'];

                    break;
                case 'Site_Renew':
                    $req_array[$value['la_id']]['cat'][$value['cat_id']]['site_renew'] += $value['total'];

                    break;
                case 'EPL_Issue':
                    $req_array[$value['la_id']]['cat'][$value['cat_id']]['certificate_issue'] += $value['total'];

                    break;
                case 'Site_Issue':
                    $req_array[$value['la_id']]['cat'][$value['cat_id']]['certificate_issue'] += $value['total'];

                    break;
            }
        }
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.category_wise_count_report_two', compact('req_array', 'time_elapsed_secs', 'from', 'to'));
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
            $siteNew = $data->where('industry_category_id', $category->id)
                ->whereBetween('site_submit_date', [$from, $to])
                ->where('site_count', 0)->count();
            $siteExtend = $data->where('industry_category_id', $category->id)
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

    public function RowReport()
    {
        $start = microtime(true);
        $client = new ClientRepository();
        $rows = $client->getRowFiles()->toArray();
        $headings = array_keys($rows[0]);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($headings);
        return view('Reports.row_file_report', compact('rows', 'time_elapsed_secs', 'headings'));
    }

    public function fileSummary($id)
    {
        $clientRepo = new ClientRepository();
        $file = $clientRepo->find($id);
        // dd($file->fileLogs->toArray());
        // dd($file->toArray());
        // dd($file->businessScale['name']);
        // $data = [];
        // $num = 0;
        // dd($data);
        $fpdf = new SummaryTemplate('p', 'mm', 'A4', 'File Summary');
        $splitSize = $fpdf->GetPageWidth() / 2 - 10;
        $fpdf->AddPage();
        $fpdf->SetFont('Times', '', 12);
        $fpdf->Cell(0, 7, "Site Code: " . $file->code_site, 0, 2);
        $fpdf->Cell(0, 7, "EPL Code: " . $file->code_epl, 0, 2);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell($splitSize, 10, "Client Details"); // client
        $fpdf->Cell($splitSize, 10, " Industry Details", 'L'); // industry
        $fpdf->SetFont('Times', '', 12);
        $fpdf->ln();
        $fpdf->Cell($splitSize, 7, "Name: " . $file->name_title . " " . $file->first_name . " " . $file->last_name); // client
        $fpdf->Cell($splitSize, 7, " Name : " . $file->industry_name, 'L'); // industry
        $fpdf->ln();
        $fpdf->Cell($splitSize, 7, "Contact No: " . $file->contact_no); // client
        $fpdf->Cell($splitSize, 7, " Contact No: " . $file->industry_contact_no, 'L'); // industry
        $fpdf->ln();
        $fpdf->Cell($splitSize, 7, "Email: " . $file->email); // client
        $fpdf->Cell($splitSize, 7, " Email" . $file->industry_email, 'L'); // industry
        $fpdf->ln();
        $fpdf->Cell($splitSize, 7, "NIC: " . $file->nic); // client
        $fpdf->Cell($splitSize, 7, " GPS (X) : " . $file->industry_coordinate_x, 'L'); // industry
        $fpdf->ln();
        $fpdf->Cell($splitSize, 7, "Address: " . $file->address); // client
        $fpdf->Cell($splitSize, 7, " GPS (Y) : " . $file->industry_coordinate_y, 'L'); // industry
        $fpdf->ln();
        $fpdf->Cell($splitSize, 7, ""); // client
        $fpdf->Cell($splitSize, 7, " Address: " . $file->industry_address, 'L'); // industry
        $fpdf->ln(15);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Other Details", 0, 2);
        $fpdf->SetFont('Times', '', 12);
        $fpdf->Cell(null, 7, "Business Scale : " . $file->businessScale['name'], 0, 2);
        $fpdf->Cell(null, 7, "Industry Category : " . $file->industryCategory['name'], 0, 2);
        $fpdf->Cell(null, 7, "Sub Category : " . $file->industry_sub_category, 0, 2);
        $fpdf->Cell(null, 7, "Pradesheeyasaba : " . $file->pradesheeyasaba['name'], 0, 2);
        $fpdf->Cell(null, 7, "Zone : " . $file->pradesheeyasaba['zone']['name'], 0, 2);
        $fpdf->Cell(null, 7, "Environment Officer : " . $file->environmentOfficer['user']['first_name'] . " " . $file->environmentOfficer['user']['last_name'], 0, 2);
        $fpdf->Cell(null, 7, "Assistance Director : " . $file->environmentOfficer['assistantDirector']['user']['first_name'] . " " . $file->environmentOfficer['user']['last_name'], 0, 2);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Site Clearence", 0, 2);
        $fpdf->SetFont('Times', '', 12);
        $j = 1;
        if (count($file->siteClearenceSessions) > 0) {
            foreach ($file->siteClearenceSessions as $sc) {
                $fpdf->Cell(null, 7, $j++ . ")", 0, 2);
                $fpdf->Cell(null, 7, "Site Clearence Code : " . $sc['code'], 0, 2);
                $fpdf->Cell(null, 7, "Site Clearence Type : " . $sc['site_clearance_type'], 0, 2);
                switch ($sc['processing_status']) {
                    case 1:
                        $pStatus = "Site Clearence";
                        break;
                    case 2:
                        $pStatus = "EIA";
                        break;
                    case 2:
                        $pStatus = "IEE";
                        break;
                    default:
                        $pStatus = "N/A";
                }
                $fpdf->Cell(null, 7, "Site Clearence Processing Type : " . $pStatus, 0, 2);
                if (count($sc->siteClearances) > 0) {
                    $fpdf->SetFont('Times', 'B', 11);
                    $fpdf->Cell(10, 7, "#", 1, 0, 'C');
                    $fpdf->Cell(20, 7, "Extension", 1, 0, 'C');
                    $fpdf->Cell(30, 7, "Extension Count", 1, 0, 'C');
                    $fpdf->Cell(25, 7, "Status", 1, 0, 'C');
                    $fpdf->Cell(25, 7, "Submit Date", 1, 0, 'C');
                    $fpdf->Cell(25, 7, "Issue Date", 1, 0, 'C');
                    $fpdf->Cell(25, 7, "Expire Date", 1, 0, 'C');
                    $fpdf->Cell(25, 7, "Rejected Date", 1, 0, 'C');
                    $fpdf->ln();
                    $fpdf->SetFont('Times', '', 11);
                    $i = 1;

                    foreach ($sc->siteClearances as $s) {
                        if ($s['count'] == 0) {
                            $extension = "New";
                        } else {
                            $extension = "Extend";
                        }
                        switch ($s['status']) {
                            case 0:
                                $status = "Pending";
                                break;
                            case 1:
                                $status = "Issued";
                                break;
                            case -1:
                                $status = "Rejected";
                                break;
                            default:
                                $status = "N/A";
                        }
                        $fpdf->Cell(10, 7, $i++, 1, 0, 'C');
                        $fpdf->Cell(20, 7, $extension, 1, 0, 'C');
                        $fpdf->Cell(30, 7, $s['count'], 1, 0, 'C');
                        $fpdf->Cell(25, 7, $status, 1, 0, 'C');
                        $fpdf->Cell(25, 7, Carbon::parse($s['submit_date'])->format('Y-m-d'), 1, 0, 'C');
                        $fpdf->Cell(25, 7, Carbon::parse($s['issue_date'])->format('Y-m-d'), 1, 0, 'C');
                        $fpdf->Cell(25, 7, Carbon::parse($s['expire_date'])->format('Y-m-d'), 1, 0, 'C');
                        $fpdf->Cell(25, 7, Carbon::parse($s['rejected_date'])->format('Y-m-d'), 1, 0, 'C');
                        $fpdf->ln();
                    }
                }
                $fpdf->ln(5);
            }
        } else {
            $fpdf->SetFont('Times', 'B', 14);
            $fpdf->Cell(null, 10, "No Site Clearances Found For this File", 0, 2);
        }
        $fpdf->AddPage();
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Environment Protection License", 0, 2);
        if (count($file->epls) > 0) {
            $fpdf->SetFont('Times', '', 12);
            $fpdf->Cell(null, 10, "EPL Code : " . $file->epls[0]['code'], 0, 2);
            $j = 1;
            $fpdf->SetFont('Times', 'B', 11);
            $fpdf->Cell(10, 7, "#", 1, 0, 'C');
            $fpdf->Cell(25, 7, "Certificate No", 1, 0, 'C');
            $fpdf->Cell(30, 7, "Renewal Count", 1, 0, 'C');
            $fpdf->Cell(25, 7, "Status", 1, 0, 'C');
            $fpdf->Cell(25, 7, "Submit Date", 1, 0, 'C');
            $fpdf->Cell(25, 7, "Issue Date", 1, 0, 'C');
            $fpdf->Cell(25, 7, "Expire Date", 1, 0, 'C');
            $fpdf->Cell(25, 7, "Rejected Date", 1, 0, 'C');
            $fpdf->ln();
            $fpdf->SetFont('Times', '', 11);
            $i = 1;
            foreach ($file->epls as $epl) {
                if ($epl['count'] == 0) {
                    $count = "New";
                } else {
                    $count = "R" . $epl['count'];
                }
                switch ($epl['status']) {
                    case 0:
                        $status = "Pending";
                        break;
                    case 1:
                        $status = "Issued";
                        break;
                    case -1:
                        $status = "Rejected";
                        break;
                    default:
                        $status = "N/A";
                }
                $fpdf->Cell(10, 7, $i++, 1, 0, 'C');
                $fpdf->Cell(25, 7, $epl['certificate_no'], 1, 0, 'C');
                $fpdf->Cell(30, 7, $count, 1, 0, 'C');
                $fpdf->Cell(25, 7, $status, 1, 0, 'C');
                $fpdf->Cell(25, 7, Carbon::parse($epl['submitted_date'])->format('Y-m-d'), 1, 0, 'C');
                $fpdf->Cell(25, 7, Carbon::parse($epl['issue_date'])->format('Y-m-d'), 1, 0, 'C');
                $fpdf->Cell(25, 7, Carbon::parse($epl['expire_date'])->format('Y-m-d'), 1, 0, 'C');
                $fpdf->Cell(25, 7, Carbon::parse($epl['rejected_date'])->format('Y-m-d'), 1, 0, 'C');
                $fpdf->ln();
            }
        } else {
            $fpdf->SetFont('Times', 'B', 14);
            $fpdf->Cell(null, 10, "No Environment Protection License Found For this File", 0, 2);
        }
        $fpdf->ln(10);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Transactions", 0, 2);
        if (count($file->transactions) > 0) {
            $p = 1;
            $fpdf->SetFont('Times', '', 12);
            foreach ($file->transactions as $transaction) {
                if ($transaction['status'] > 0) {
                    $fpdf->Cell(null, 7, $p++ . ")", 0, 2);
                    $fpdf->Cell(null, 7, "Invoice No : " . $transaction['invoice_no'], 0, 2);
                    $fpdf->Cell(null, 7, "Billed At : " . Carbon::parse($transaction['billed_at'])->format('Y-m-d'), 0, 2);
                    if ($transaction['status'] == 3) {
                        $fpdf->Cell(null, 7, "Cancelled At : " . Carbon::parse($transaction['canceled_at'])->format('Y-m-d'), 0, 2);
                    }
                    $fpdf->Cell(null, 7, "Net Amount : " . number_format($transaction['net_total']), 0, 2);
                    $fpdf->Cell(null, 7, "Cashier Name : " . $transaction['cashier_name'], 0, 2);
                    $fpdf->SetFont('Times', '', 12);

                    $fpdf->SetFont('Times', 'B', 11);
                    $fpdf->Cell(25, 7, "#", 1, 0, 'C');
                    $fpdf->Cell(100, 7, "Payment Type", 1, 0, 'C');
                    $fpdf->Cell(50, 7, "Amount", 1, 0, 'C');
                    $fpdf->ln();
                    $fpdf->SetFont('Times', '', 11);
                    $i = 1;
                    foreach ($transaction->transactionItems as $items) {
                        $fpdf->Cell(25, 7, $i++, 1, 0, 'C');
                        // dd($items['payment']['paymentType']);
                        $fpdf->Cell(100, 7, $items['payment']['paymentType']['name'], 1, 0, 'L');
                        $fpdf->Cell(50, 7, number_format($items['amount'], 2), 1, 0, 'R');
                        $fpdf->ln();
                    }
                }
            }
        } else {
            $fpdf->SetFont('Times', 'B', 14);
            $fpdf->Cell(null, 10, "No Transactions Found For this File", 0, 2);
        }
        $fpdf->ln(10);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Inspections", 0, 2);
        if (count($file->inspectionSessions) > 0) {
            $fpdf->SetFont('Times', 'B', 11);
            $fpdf->Cell(10, 7, "#", 1, 0, 'C');
            $fpdf->Cell(50, 7, "Schedule Date", 1, 0, 'C');
            $fpdf->Cell(50, 7, "Completed Date", 1, 0, 'C');
            $fpdf->Cell(70, 7, "Environment Officer", 1, 0, 'C');
            $fpdf->ln();
            $fpdf->SetFont('Times', '', 11);
            $i = 1;
            foreach ($file->inspectionSessions as $inspection) {
                $fpdf->Cell(10, 7, $i++, 1, 0, 'C');
                $fpdf->Cell(50, 7, Carbon::parse($inspection->schedule_date)->format('Y-m-d'), 1, 0, 'C');
                $fpdf->Cell(50, 7, Carbon::parse($inspection->completed_at)->format('Y-m-d'), 1, 0, 'C');
                // dd($inspection->environmentOfficer->user->first_name);
                $fpdf->Cell(70, 7, $inspection->environmentOfficer->user->first_name . " " . $inspection->environmentOfficer->user->last_name, 1, 0, 'L');
                $fpdf->ln();
            }
        } else {
            $fpdf->SetFont('Times', 'B', 14);
            $fpdf->Cell(null, 10, "No Inspections Found For this File", 0, 2);
        }
        $fpdf->ln(10);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Committees", 0, 2);
        if (count($file->inspectionSessions) > 0) {
            $fpdf->SetFont('Times', '', 12);
            $j = 1;
            foreach ($file->committees as $committees) {
                $fpdf->Cell(null, 7, $j++ . ")", 0, 2);
                $fpdf->Cell(null, 5, "Schedule Date : " . $committees->schedule_date, 0, 2);
                $fpdf->Cell(null, 7, "Description : " . $committees->remark, 0, 2);
                $fpdf->SetFont('Times', 'B', 11);
                $fpdf->Cell(null, 5, "Members : ", 0, 2);
                $fpdf->SetFont('Times', '', 11);
                foreach ($committees->commetyPool as $pool) {
                    $fpdf->Cell(null, 5, $pool->first_name . " " . $pool->last_name, 0, 2);
                }
                $fpdf->ln(5);
            }
        } else {
            $fpdf->SetFont('Times', 'B', 14);
            $fpdf->Cell(null, 10, "No Committees Found For this File", 0, 2);
        }
        $fpdf->ln(5);
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "Minutes", 0, 2);
        if (count($file->minutes) > 0) {

            foreach ($file->minutes as $minutes) {
                $fpdf->SetFont('Times', '', 12);
                $fpdf->Cell($splitSize - 5, 5, "Name : " . $minutes->user->first_name . " " . $minutes->user->last_name, 0, 0);
                $fpdf->Cell($splitSize, 5, "Minute Date : " . Carbon::parse($minutes['created_at'])->format('Y-m-d'), 0, 0);
                $fpdf->ln();
                $fpdf->Cell(null, 1, '', 'B', 2);
                $fpdf->ln();
                $fpdf->SetFont('Times', 'B', 11);
                $fpdf->Cell(null, 5, "Description : ", 0, 2);
                $fpdf->SetFont('Times', '', 11);
                $fpdf->MultiCell(null, 10, $minutes->minute_description, 0, 2);
            }
        } else {
            $fpdf->SetFont('Times', 'B', 14);
            $fpdf->Cell(null, 10, "No Committees Found For this File", 0, 2);
        }
        $fpdf->AddPage();
        $fpdf->SetFont('Times', 'B', 14);
        $fpdf->Cell(null, 10, "File Activity Log (System Log)", 0, 2);
        $fpdf->SetFont('Times', 'B', 11);
        $fpdf->Cell(10, 7, "#", 1, 0, 'C');
        $fpdf->Cell(30, 7, "Date", 1, 0, 'C');
        $fpdf->Cell(50, 7, "User", 1, 0, 'C');
        $fpdf->Cell(90, 7, "Description", 1, 0, 'C');
        $fpdf->ln();
        $fpdf->SetFont('Times', '', 11);
        $i = 1;
        foreach ($file->fileLogs as $fileLog) {
            $fpdf->Cell(10, 7, $i++, 1, 0, 'C');
            $fpdf->Cell(30, 7, Carbon::parse($fileLog['created_at'])->format('Y-m-d'), 1, 0, 'C');
            // dd($fileLog->user->last_name);
            if ($fileLog->user) {

                $fpdf->Cell(50, 7, $fileLog->user->first_name . " " . $fileLog->user->last_name, 1, 0, 'L');
            } else {
                $fpdf->Cell(50, 7, "N/A", 1, 0, 'L');
            }
            $fpdf->Cell(90, 7, $fileLog->description, 1, 0, 'L');
            $fpdf->ln();
        }
        $fpdf->Output();
        exit;
    }

    public function downloadContents(Client $client)
    {
        // dd($client);
        $zip_file = 'attachments_of_' . $client->industry_name . 'zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // $path = storage_path(FieUploadController::getClientFolderPath($client));
        $path = "storage/uploads/" . FieUploadController::getClientFolderPath($client);
        // dd($path);
        $files = Storage::allFiles("public/uploads/industry_files/" . $client->id);
        // $files = Storage::allFiles("uploads/" . FieUploadController::getClientFolderPath($client));
        // dd($files);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {
            // dd($file->getPath());
            // We're skipping all subfolders
            if (file_exists($file) && is_file($file)) {
                $filePath = $file->getRealPath();
                // dd($filePath);
                $relativePath = substr($file->getPath(), strlen("storage/uploads/industry_files/"));
                // dd($relativePath);

                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        $rtn = response()->download($zip_file)->deleteFileAfterSend(true);
        // unlink($zip_file);
        return $rtn;
    }

    public function siteClearanceApplicationLog($from, $to)
    {
        $start = microtime(true);
        $site = new SiteClearenceRepository();
        $result = $site->getSiteReport($from, $to);
        //        dd($result);
        $data = [];
        $data['header_count'] = 0;
        $data['results'] = [];
        $num = 0;
        foreach ($result as $row) {
            $array = [];
            $array['#'] = ++$num;
            $array['industry_start_date'] = Carbon::parse($row['created_at'])->format('Y-m-d');
            $array['code_site'] = $row['code'];
            $array['name_title'] = $row['client']['name_title'] . ' ' . $row['client']['first_name'] . ' ' . $row['client']['last_name'] . "\n" . $row['client']['address'];
            $array['category_name'] = $row['client']['industry_category']['name'];
            $array['industry_address'] = $row['client']['industry_address'];
            $array['nature'] = $row['site_clearance_type'];
            $array['code'] = $row['code'];
            array_push($data['results'], $array);
        }

        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.site_report_log', ['data' => $data, 'time_elapsed_secs' => $time_elapsed_secs, 'from' => $from, 'to' => $to]);
    }

    public function fileProgressReport(Request $request)
    {
        $file_type_status = [
            0 => 'pending',
            1 => 'New EPL',
            2 => 'EPL Renew',
            3 => 'Site Clearance',
            4 => 'Extend Site Clearance',
        ];
        $file_status = [
            0 => 'EO pending',
            1 => 'AD File Approval Pending',
            2 => 'Certificate Preparation',
            3 => 'AD Certificate Prenidng Approval',
            4 => 'D Certificate Approval Prenidng',
            5 => 'Complete',
            6 => 'Issued',
            7 => 'Not Assigned',
            '-1' => 'Rejected',
            '-2' => 'Hold'
        ];
        $clients = Client::select('id', 'first_name', 'last_name', 'updated_at', 'deleted_at', 'industry_name', 'file_no', 'file_status', 'cer_type_status', 'cer_status', 'industry_category_id', 'environment_officer_id', 'created_at')->with('industryCategory')
            ->where('file_status', '<>', 5)
            ->where('file_status', '<>', 6)
            ->orderBy('updated_at', 'ASC')
            // ->limit(10)
            ->get();

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('file_progress_report', [
            'pageAuth' => $pageAuth,
            'report_data' => $clients,
            'file_type_status' => $file_type_status,
            'file_status' => $file_status,
        ]);
    }
}
