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
use App\Certificate;
use App\EPL;
use App\EPLNew;
use App\FileLog;
use App\SiteClearenceSession;
use DB;

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
        $result = $site->getSiteClearenceReportBySubmitDate($from, $to, $type)->toArray();
        $data = [];
        $num = 0;
        foreach ($result as $row) {
            $array = [];
            $array[] = ++$num;
            $array[] = $row['code'];
            $array[] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'];
            $array[] = $row['category_name'] . (($row['industry_sub_category'] != '') ? ' (' . $row['industry_sub_category'] . ')' : '');
            $array[] = $row['industry_address'];
            $array[] = '';
            // $array[] = 'Fee : ' . $row['amount'] . ' ' . "\nInvoice No : " . $row['invoice_no'] . "\nDate : " . Carbon::parse($row['billed_at'])->format('Y-m-d');
            ($row['submit_date'] != null) ? $array[] = Carbon::parse($row['submit_date'])->format('Y-m-d') : $array[] = 'N/A';
            ($row['issue_date'] != null) ? $array[] = Carbon::parse($row['issue_date'])->format('Y-m-d') : $array[] = 'N/A';
            $array[] = '';
            // ($row['created_at'] != null) ? $array[] = Carbon::parse($row['created_at'])->format('Y-m-d') : $array[] = 'N/A';
            if ($row['count'] > 0) {
                $array[] = 'Extend';
            } else {
                $array[] = 'New';
            }
            $array[] = $row['client_id'];
            $array[] = $row['address'];

            array_push($data, $array);
        }
        switch ($type) {
            case 'all':
                $title = "Site Clearance Report (All)";
                break;
            case 'new':
                $title = "Site Clearance Report (New)";
                break;
            case 'extend':
                $title = "Site Clearance Report (Extend)";
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

            //validate and set dates of the report
            (isset($row['submitted_date'])) ? $array['submitted_date'] =  Carbon::parse($row['submitted_date'])->format('Y-m-d') : $array['submitted_date'] = 'N/A';
            (isset($row['issue_date'])) ? $array['issue_date'] = Carbon::parse($row['issue_date'])->format('Y-m-d') : $array['issue_date'] = 'N/A';
            (isset($row['created_at'])) ? $array['created_at'] = Carbon::parse($row['created_at'])->format('Y-m-d') : $array['created_at'] = 'N/A';

            $array['code'] = $row['code'];
            $client = $row['client'];
            $array['name_title'] =  $client['name_title'] . ' ' . $client['first_name'] . ' ' . $client['last_name'] . "\n";
            $array['address'] = $client['address'];
            $array['category_name'] = $client['industry_category']['name'] . (($client['industry_sub_category'] != '') ? ' (' . $client['industry_sub_category'] . ')' : '');
            $array['industry_address'] = $client['industry_address'];
            if (isset($client['transactions']) && count($client['transactions']) > 0 && count($client['transactions'][0]['transaction_items']) > 0) {
                $array['inspection_fee'] = $client['transactions'][0]['transaction_items'][0]['amount'];
                $array['inspection_pay_date'] = Carbon::parse($client['transactions'][0]['billed_at'])->format('Y-m-d');
            } else {
                $array['inspection_fee'] = "N/A";
                $array['inspection_pay_date'] = "N/A";
            }
            $certificate_no = isset($row['certificate_no']) ? $row['certificate_no'] : 'N/A';
            $file_no = isset($row['client']['file_no']) ? $row['client']['file_no'] : 'N/A';
            $ref_no = isset($row['client']['certificates'][0]['refference_no']) ? $row['client']['certificates'][0]['refference_no'] : 'N/A';

            $array['file_no'] = $file_no;
            $array['ref_no'] = $ref_no;
            $array['license_number'] = $certificate_no;
            $array['client_id'] =  $client['id'];
            if ($row['count'] > 0) {
                $array['nature'] = 'Renew';
            } else {
                $array['nature'] = 'New';
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
        $epls = new EPLRepository();
        $result = $epls->getEPLApplicationLog($from, $to)->toArray();
        $data = [];
        $num = 0;
        foreach ($result as $row) {
            $array = [];
            $array['#'] = ++$num;
            (isset($row['submitted_date'])) ? $array['submitted_date'] = Carbon::parse($row['submitted_date'])->format('Y-m-d') : 'N/A';
            $array['code'] = $row['code'];

            $client = $row['client'];
            $name_title = isset($client['name_title']) ? $client['name_title'] : 'N/A';
            $first_name = isset($client['first_name']) ? $client['first_name'] : 'N/A';
            $last_name = isset($client['last_name']) ? $client['last_name'] : 'N/A';
            $client_address = isset($client['address']) ? $client['address'] : 'N/A';
            $industry_category = $client['industry_category']['name'] . (($client['industry_sub_category'] != '') ? ' (' . $client['industry_sub_category'] . ')' : '');
            $industry_address = isset($client['industry_address']) ? $client['industry_address'] : '-';
            $array['name_title'] = $name_title . ' ' . $first_name . ' ' . $last_name;
            $array['category_name'] = $industry_category;
            $array['address'] = $client_address;
            $array['industry_address'] = $industry_address;

            $type = '';
            ($row['count'] > 0) ? $type = 'Renew' : $type = 'New';

            if (isset($row['client']['site_clearence_sessions']) && count($row['client']['site_clearence_sessions']) > 0) {
                $array['nature'] = "SC -> EPL";
            } else {
                $array['nature'] = "EPL";
            }
            $array['nature'] = $array['nature'] . '(' . $type . ')';
            $array['client_id'] = $client['id'];
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
        $result[] = array('type' => 'received', 'name' => 'SC(EX)', 'application' => $this->prepareApplicationTotal($siteExtendCount->toArray()), 'object' => $this->prepareCount($siteExtendCount->toArray(), $assistanceDirectors));
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

        $result[] = array('type' => 'Inspection', 'name' => 'SC(EX)', 'application' => "", 'object' => $this->prepareCount($siteInspectionRenewCount->toArray(), $assistanceDirectors));

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

        $result[] = array('type' => 'Issued', 'name' => 'SC(EX)', 'application' => "", 'object' => $this->prepareCount($completedRenewSiteCount->toArray(), $assistanceDirectors));

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
        $rejectedEplCount = $epl->EPlPLCount($from, $to, 3, 2);
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
        $telecommunicationCount = $site->telicomTowerCount($from, $to, 'Application');
        $towerEplNewCount = $epl->TowerEPlPLCount($from, $to, 1, 0);
        $towerEplRenewCount = $epl->TowerEPlPLCount($from, $to, 0, 0);


        $result[] = array('type' => '', 'name' => 'Meeting/Test Blast', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Joint Inspection', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Trainings', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'SWML', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower (EPL R)', 'application' => $this->prepareApplicationTotal($towerEplRenewCount->toArray()), 'object' => $this->prepareCount($towerEplRenewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower (EPL N)', 'application' => $this->prepareApplicationTotal($towerEplNewCount->toArray()), 'object' => $this->prepareCount($towerEplNewCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Tower SC', 'application' => $this->prepareApplicationTotal($telecommunicationCount->toArray()), 'object' => $this->prepareCount($telecommunicationCount->toArray(), $assistanceDirectors));
        $result[] = array('type' => '', 'name' => 'Expert Committee Meetings', 'application' => "", 'object' => $this->prepareCount(array(), $assistanceDirectors));
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        return view('Reports.monthly_progress_report', compact('result', 'assistanceDirectors', 'time_elapsed_secs', 'from', 'to'));
    }

    private function prepareCount($array, $assistanceDirectors, $flag = true)
    {
        $rtn = [];
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
        $categoryRepo = new IndustryCategoryRepository();
        $category = $categoryRepo->all()->keyBy('id')->toArray();
        // new epls
        $eplNew = EPL::selectRaw('Count(e_p_l_s.issue_date) AS new_epl_count, clients.industry_category_id')
            ->whereNotNull('issue_date')
            ->where('count', '=', 0)
            ->whereBetween('issue_date', [$from, $to])
            ->join('clients', 'e_p_l_s.client_id', '=', 'clients.id')
            ->groupBy('clients.industry_category_id')
            ->get()->keyBy('industry_category_id')->toArray();
        // epl renew count
        $eplRenew = EPL::selectRaw('Count(e_p_l_s.issue_date) AS renew_epl_count, clients.industry_category_id')
            ->whereNotNull('issue_date')
            ->where('count', '>', 0)
            ->whereBetween('issue_date', [$from, $to])
            ->join('clients', 'e_p_l_s.client_id', '=', 'clients.id')
            ->groupBy('clients.industry_category_id')
            ->get()->keyBy('industry_category_id')->toArray();
        // site new count
        $siteNew = SiteClearance::selectRaw('Count(site_clearances.issue_date) AS site_new_count, clients.industry_category_id')
            ->whereNotNull('site_clearances.issue_date')
            ->whereNull('site_clearances.deleted_at')
            ->where('count', '=', 0)
            ->whereBetween('site_clearances.issue_date', [$from, $to])
            ->join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', '=', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', '=', 'clients.id')
            ->groupBy('clients.industry_category_id')
            ->get()->keyBy('industry_category_id')->toArray();

        // site renew count
        $siteRenew = SiteClearance::selectRaw('Count(site_clearances.issue_date) AS site_extend_count, clients.industry_category_id')
            ->whereNotNull('site_clearances.issue_date')
            ->whereNull('site_clearances.deleted_at')
            ->where('count', '>', 0)
            ->whereBetween('site_clearances.issue_date', [$from, $to])
            ->join('site_clearence_sessions', 'site_clearances.site_clearence_session_id', '=', 'site_clearence_sessions.id')
            ->join('clients', 'site_clearence_sessions.client_id', '=', 'clients.id')
            ->groupBy('clients.industry_category_id')
            ->get()->keyBy('industry_category_id')->toArray();


        foreach ($category as $key => $value) {
            $row = array(
                "name" => $value['name'],
                "sc_new" => 0,
                "sc_extend" => 0,
                "epl_new" => 0,
                "epl_renew" => 0,
                "certificates" => 0,
            );
            if (isset($siteNew[$key])) {
                $row['sc_new'] = $siteNew[$key]['site_new_count'];
            }
            if (isset($siteRenew[$key])) {
                $row['sc_extend'] = $siteRenew[$key]['site_extend_count'];
            }
            if (isset($eplNew[$key])) {
                $row['epl_new'] = $eplNew[$key]['new_epl_count'];
            }
            if (isset($eplRenew[$key])) {
                $row['epl_renew'] = $eplRenew[$key]['renew_epl_count'];
            }
            array_push($rows, $row);
        }
        $time_elapsed_secs = round(microtime(true) - $start, 5);
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

                $fpdf->Cell(
                    50,
                    7,
                    $fileLog->user->first_name . " " . $fileLog->user->last_name,
                    1,
                    0,
                    'L'
                );
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
        $data = [];
        $data['header_count'] = 0;
        $data['results'] = [];
        $num = 0;
        foreach ($result as $row) {
            // dd($row);
            $array = [];
            $array['#'] = ++$num;
            $array['submit_date'] = Carbon::parse($row['submit_date'])->format('Y-m-d');
            $array['code_site'] = $row['code'];
            $array['name_title'] = $row['name_title'] . ' ' . $row['first_name'] . ' ' . $row['last_name'];
            $array['address'] = $row['address'];
            $array['category_name'] = $row['industry_category'] . (($row['industry_sub_category'] != '') ? ' (' . $row['industry_sub_category'] . ')' : '');
            $array['industry_address'] = $row['industry_address'];
            $site_type = ($row['count'] > 0) ? $site_type = "EXT" : $site_type = 'NEW';
            $array['nature'] = $row['site_clearance_type'] . '(' . $site_type . ')';
            $array['code'] = $row['code'];
            $array['client_id'] = $row['id'];
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
            ->with('epls', 'siteClearenceSessions.siteClearances')
            ->where('file_status', '<>', 5)
            ->where('file_status', '<>', 6)
            ->orderBy('updated_at', 'ASC')
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

    public function warnReport(Request $request)
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $date = Carbon::now();
        $date = $date->addDays(30);
        $ad_id = $request->ad_id;
        $ad_check = $request->ad_check;

        $responses = Certificate::With(['Client.pradesheeyasaba', 'Client.warningLetters'])->selectRaw('max(id) as id, client_id, expire_date,cetificate_number,certificate_type');

        if ($ad_check == 'on') {
            $responses = $responses->whereHas('Client.environmentOfficer.assistantDirector', function ($query) use ($ad_id) {
                $query->where('assistant_directors.id', '=', $ad_id);
            });
        } else {
            $responses = $responses->where('certificate_type', '=', 0);
        }
        $responses = $responses->where('expire_date', '<', $date)
            ->groupBy('client_id')
            ->get();

        $reses = $responses->toArray();

        foreach ($reses as $k => $res) {
            $origin = date_create(date("Y-m-d"));
            $target = date_create(date($res['expire_date']));
            $interval = date_diff($origin, $target);

            if ($interval->format('%R%a days') > 0) {
                $reses[$k]['due_date'] = $interval->format('Expire within %a days');
            } else {
                $reses[$k]['due_date'] = "expired";
            }
        }

        return view('Reports.warn_report', ['warn_let_data' => $reses]);
    }

    // return site clearence data of expired date is null
    public function pendingSiteClearReport()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        $pending_site_clear_data = SiteClearance::where('expire_date', null)
            ->with('siteClearenceSession.client.pradesheeyasaba', 'siteClearenceSession.client.environmentOfficer.user')
            ->get();
        return view('Reports.pending_site_clearence_report', ['pending_site_clear_data' => $pending_site_clear_data, 'pageAuth' => $pageAuth]);
    }

    public function pendingEplReport()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        $pending_epl_data = Epl::where('expire_date', null)
            ->with('client.pradesheeyasaba', 'client.environmentOfficer.user')
            ->get();
        return view('Reports.pending_epl_report', ['pending_epl_data' => $pending_epl_data, 'pageAuth' => $pageAuth]);
    }

    public function statusMismatchEpl()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $file_status = Client::FILE_STATUS;
        $status_mismatch_data = Epl::join('clients', 'e_p_l_s.client_id', '=', 'clients.id')
            ->leftjoin('environment_officers', 'clients.environment_officer_id', '=', 'environment_officers.id')
            ->leftjoin('users', 'environment_officers.user_id', '=', 'users.id')
            ->where('e_p_l_s.status', 0)
            ->where('clients.file_status', '=', 5)
            ->select('clients.id', 'clients.file_no', 'clients.industry_name', 'clients.file_status', 'e_p_l_s.submitted_date', 'users.first_name', 'users.last_name')
            ->get();
        return view('Reports.status_mismatch_report', ['status_mismatch_data' => $status_mismatch_data, 'pageAuth' => $pageAuth, 'file_status' => $file_status]);
    }

    public function certMissingReport()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $file_status = Client::FILE_STATUS;
        $missing_cert_data = Epl::with('client.environmentOfficer.user')
            ->whereNotIn('e_p_l_s.client_id', Certificate::select('client_id')->groupBy('client_id')->get()->toArray())
            ->groupBy('client_id')
            ->get()
            ->toArray();
        return view('Reports.cert_missing_report', ['missing_cert_data' => $missing_cert_data, 'pageAuth' => $pageAuth, 'file_status' => $file_status]);
    }

    //get completed files list
    public function viewCompletedFiles(Request $request)
    {
        $start_data = $request->start_data;
        $end_date = $request->end_date;

        $completedEPL = DB::table('e_p_l_s')
            ->select(
                'clients.industry_name AS industry_name',
                'clients.file_no AS file_number',
                'clients.id AS clientid',
                'clients.industry_sub_category AS industry_sub_category',
                'pradesheeyasabas.name AS pradesheeyasaba',
                'e_p_l_s.code AS code',
                'e_p_l_s.issue_date AS issue_date',
                'e_p_l_s.expire_date AS expire_date',
                'e_p_l_s.certificate_no AS certificate_number',
                'zones.name AS Ad_name',
                'industry_categories.name AS industry_category',
                DB::raw('( SELECT created_at FROM file_logs WHERE client_id = e_p_l_s.client_id  AND description LIKE \'Director % Approve the Certificate\' ORDER BY created_at DESC LIMIT 1 ) AS director_approve_date'),
                DB::raw('( SELECT id FROM file_logs WHERE client_id = e_p_l_s.client_id AND description LIKE \'Director % Approve the Certificate\' ORDER BY created_at DESC LIMIT 1 ) AS file_log_id')
            )
            ->join('clients', 'e_p_l_s.client_id', '=', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', '=', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->join('file_logs', 'clients.id', 'file_logs.client_id')
            ->where('e_p_l_s.status', 1)
            ->where('file_logs.code', 'Approval')
            ->where('file_logs.file_type', 'epl')
            ->whereBetween('e_p_l_s.issue_date', [$start_data, $end_date])
            ->groupBy('e_p_l_s.code')
            ->orderBy('clients.industry_name')
            ->get();

        $completedSC = DB::table('site_clearence_sessions')
            ->select(
                'clients.industry_name AS industry_name',
                'clients.file_no AS file_number',
                'clients.industry_sub_category AS industry_sub_category',
                'pradesheeyasabas.name AS pradesheeyasaba',
                'site_clearence_sessions.code AS code',
                'site_clearence_sessions.issue_date AS issue_date',
                'site_clearence_sessions.expire_date AS expire_date',
                'site_clearence_sessions.licence_no AS certificate_number',
                'zones.name AS Ad_name',
                'industry_categories.name AS industry_category',
                DB::raw('( SELECT created_at FROM file_logs WHERE client_id = site_clearence_sessions.client_id AND description LIKE \'Director % Approve the Certificate\' ORDER BY created_at DESC LIMIT 1 ) AS director_approve_date'),
                DB::raw('( SELECT id FROM file_logs WHERE client_id = site_clearence_sessions.client_id AND description LIKE \'Director % Approve the Certificate\' ORDER BY created_at DESC LIMIT 1 ) AS file_log_id')
            )
            ->join('clients', 'site_clearence_sessions.client_id', '=', 'clients.id')
            ->join('pradesheeyasabas', 'clients.pradesheeyasaba_id', '=', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
            ->join('file_logs', 'clients.id', 'file_logs.client_id')
            ->where('site_clearence_sessions.status', 1)
            ->where('file_logs.file_type', 'sc')
            ->where('file_logs.code', 'Approval')
            ->whereBetween('site_clearence_sessions.issue_date', [$start_data, $end_date])
            ->groupBy('site_clearence_sessions.code')
            ->orderBy('clients.industry_name')
            ->get();

        $merged = $completedSC->merge($completedEPL);

        $result = $merged->all();

        return view('Reports.completed_files', compact('result', 'start_data', 'end_date'));
    }
}
