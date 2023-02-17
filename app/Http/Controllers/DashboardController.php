<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\SiteClearance;
use App\ApplicationType;
use App\EPL;
use App\InspectionSession;
use Illuminate\Http\Request;
use App\SiteClearenceSession;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientRepository;
use App\Repositories\IndustryCategoryRepository;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = Auth::user();
        $count = InspectionSession::where('status', 0)->count();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return view('dashboard', ['pageAuth' => $pageAuth, 'count' => $count]);
    }

    public function renewalChart($from, $to)
    {
        $from = date("Y-01-01");
        $to = date("Y-12-31");
        $start = microtime(true);
        $rtn = [];
        $monthRange = $this->getMonths($from, $to);
        $eplRenewalCount = EPL::whereBetween('submitted_date', [$from, $to])
            ->where('count', '>', 0)
            ->groupByRaw('month(submitted_date)')
            ->selectRaw("DATE_FORMAT(submitted_date, '%b')  as submitted_month, count(id) as id_count")
            ->orderBy('submitted_date')
            ->get()->keyBy('submitted_month')->toArray();
        $expiredEplCount = EPL::whereBetween('expire_date', [$from, $to])
            ->groupByRaw('month(expire_date)')
            ->selectRaw("DATE_FORMAT(expire_date, '%b') as expire_date, count(id) as id_count")
            ->orderBy('expire_date')
            ->get()->keyBy('expire_date')->toArray();
        $siteClearanceCount = SiteClearance::whereBetween('submit_date', [$from, $to])
            ->where('count', '>', 0)
            ->groupByRaw('month(submit_date)')
            ->selectRaw("DATE_FORMAT(submit_date, '%b') as submitted_month, count(id) as id_count")
            ->orderBy('submit_date')->get()->keyBy('submitted_month')->toArray();

        $siteClearanceExpire = SiteClearance::whereBetween('expire_date', [$from, $to])
            ->where('count', '>', 0)
            ->groupByRaw('month(expire_date)')
            ->selectRaw("DATE_FORMAT(expire_date, '%b') as expire_month, count(id) as id_count")
            ->orderBy('expire_date')->get()->keyBy('expire_month')->toArray();
        $currentMonth = intval(date('m'));
        $eplRenewals = [];
        $expiredEpls = [];
        $siteClearences = [];
        $siteClearenceExpireCount = [];
        foreach ($monthRange as $mr) {
            $monthNumber = intval(date("m", strtotime($mr)));

            if ($monthNumber <= $currentMonth) {
                if (!array_key_exists($mr, $eplRenewalCount)) {
                    $eplRenewals[] = 0;
                } else {
                    $eplRenewals[] = $eplRenewalCount[$mr]['id_count'];
                }
                if (!array_key_exists($mr, $siteClearanceCount)) {
                    $siteClearences[] = 0;
                } else {
                    $siteClearences[] = $siteClearanceCount[$mr]['id_count'];
                }
            }

            if (!array_key_exists($mr, $expiredEplCount)) {
                $expiredEpls[] = 0;
            } else {
                $expiredEpls[] = $expiredEplCount[$mr]['id_count'];
            }

            if (!array_key_exists($mr, $siteClearanceExpire)) {
                $siteClearenceExpireCount[] = 0;
            } else {
                $siteClearenceExpireCount[] = $siteClearanceExpire[$mr]['id_count'];
            }
        }

        $time_elapsed_secs = round(microtime(true) - $start, 5);

        $rtn["renew"] = $eplRenewals;
        $rtn["expire"] = $expiredEpls;
        $rtn["siteClearence"] = $siteClearences;
        $rtn["siteClearenceExpire"] = $siteClearenceExpireCount;
        $rtn["months"] = $monthRange;
        $rtn["time"] = $time_elapsed_secs;

        return $rtn;
    }

    public function newFIleChart($from, $to)
    {
        $from = date("Y-01-01");
        $to = date("Y-12-31");
        $start = microtime(true);
        $rtn = [];

        $monthRange = $this->getMonths($from, $to);
        $eplRenewalCount = EPL::whereBetween('submitted_date', [$from, $to])
            ->where('count', 0)
            ->groupByRaw('month(submitted_date)')
            ->selectRaw("DATE_FORMAT(submitted_date, '%b')  as submitted_month, count(id) as id_count")
            ->orderBy('submitted_date')
            ->get()->keyBy('submitted_month')->toArray();

        $siteClearanceCount = SiteClearance::whereBetween('submit_date', [$from, $to])
            ->where('count', 0)
            ->groupByRaw('month(submit_date)')
            ->selectRaw("DATE_FORMAT(submit_date, '%b') as submitted_month, count(id) as id_count")
            ->orderBy('submit_date')->get()->keyBy('submitted_month')->toArray();

        $eplRenewals = [];
        $siteClearences = [];

        foreach ($monthRange as $mr) {
            if (!array_key_exists($mr, $eplRenewalCount)) {
                $eplRenewals[] = 0;
            } else {
                $eplRenewals[] = $eplRenewalCount[$mr]['id_count'];
            }
            if (!array_key_exists($mr, $siteClearanceCount)) {
                $siteClearences[] = 0;
            } else {
                $siteClearences[] = $siteClearanceCount[$mr]['id_count'];
            }
        }

        $time_elapsed_secs = round(microtime(true) - $start, 5);

        $rtn["epl"] = $eplRenewals;
        $rtn["site"] = $siteClearences;
        $rtn["months"] = $monthRange;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }
    public function newFIleChartV2($from, $to)
    {
        $from = date("Y-01-01");
        $to = date("Y-12-31");
        $start = microtime(true);
        $rtn = [];

        $monthRange = $this->getMonths($from, $to);
        $eplRenewalCount = EPL::whereBetween('submitted_date', [$from, $to])
            ->where('count', 0)
            ->groupByRaw('month(submitted_date)')
            ->selectRaw("DATE_FORMAT(submitted_date, '%b')  as submitted_month, count(id) as id_count")
            ->orderBy('submitted_date')
            ->get()->keyBy('submitted_month')->toArray();

        $siteClearanceCount = SiteClearance::whereBetween('submit_date', [$from, $to])
            ->where('count', 0)
            ->groupByRaw('month(submit_date)')
            ->selectRaw("DATE_FORMAT(submit_date, '%b') as submitted_month, count(id) as id_count")
            ->orderBy('submit_date')->get()->keyBy('submitted_month')->toArray();

        $eplRenewals = [];
        $siteClearences = [];

        foreach ($monthRange as $mr) {
            if (!array_key_exists($mr, $eplRenewalCount)) {
                $eplRenewals[] = 0;
            } else {
                $eplRenewals[] = $eplRenewalCount[$mr]['id_count'];
            }
            if (!array_key_exists($mr, $siteClearanceCount)) {
                $siteClearences[] = 0;
            } else {
                $siteClearences[] = $siteClearanceCount[$mr]['id_count'];
            }
        }

        $time_elapsed_secs = round(microtime(true) - $start, 5);

        $rtn["epl"] = $eplRenewals;
        $rtn["site"] = $siteClearences;
        $rtn["months"] = $monthRange;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    public function IssueFileCategory($from, $to)
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $categoryRepo = new IndustryCategoryRepository();
        // dd($categories->toArray());
        $data = $client->allPlain($from, $to);
        $categories = [];
        $count = [];
        foreach ($categoryRepo->all()->toArray() as $category) {
            $eplCertificate = $data->where('industry_category_id', $category['id'])
                ->whereBetween('epl_issue_date', [$from, $to])->count();
            $siteCertificate = $data->where('industry_category_id', $category['id'])
                ->whereBetween('site_issue_date', [$from, $to])->count();
            array_push($count, $eplCertificate + $siteCertificate);
            array_push($categories, $category['name']);
        }
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["categories"] = $categories;
        $rtn["count"] = $count;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    public function getNewJobsByType($from, $to)
    {
        $start = microtime(true);
        $rtn = [];
        $time = strtotime(date("Y-m-01"));
        $final = date("Y-m-01", strtotime("+1 month", $time));
        $from = date("Y-m-01");
        $to = $final;

        $eplCount = EPL::whereBetween('submitted_date', [$from, $to])
            // ->where('count', 0)
            ->count();

        $siteClearanceCount = SiteClearance::with('siteClearenceSession')->whereBetween('submit_date', [$from, $to])
            ->whereHas('siteClearenceSession', function ($query) {
                $query->where('site_clearance_type', 'Site Clearance');
            })
            // ->where('count', 0)
            ->count();

        $siteClearanceTeleCount = SiteClearance::with('siteClearenceSession')->whereBetween('submit_date', [$from, $to])
            ->whereHas('siteClearenceSession', function ($query) {
                $query->where('site_clearance_type', 'Telecommunication');
            })
            // ->where('count', 0)
            ->count();

        $types = array("EPL", "Site Clearance", "Tele Communication", "Schedule Waste");

        $scheduleWaste = 0;

        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["types"] = $types;
        $rtn["count"] = array($eplCount, $siteClearanceCount, $siteClearanceTeleCount, $scheduleWaste);
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    private function pradesheyasabaFileCount()
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->fileCountByPradesheeyaSaba();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["data"] = $data;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    private function environmentOfficerFileCount()
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->fileCountByEnvironmentOfficer();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["data"] = $data;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    private function industryCategoryFileCount()
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->fileCountByIndustryCategory();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["data"] = $data;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    private function FileStatusFileCount()
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->fileCountByFileStatus();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($data->toArray());
        $r = [];
        for ($i = 0; $i < 7; $i++) {
            $a = array('file_status' => $i, 'total' => 0);
            foreach ($data as $d) {
                if ($d->file_status == $i) {
                    $a['total'] =  $d->total;
                }
            }
            array_push($r, $a);
        }
        // dd($r);
        $rtn["data"] = $r;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    public function getDashboardData(Request $request)
    {
        //        print_r($request);
        $start = microtime(true);
        $rtn = [];
        if ($request->has('renew_chart')) {
            $from = $request->renew_chart['from'];
            $to = $request->renew_chart['to'];
            $rtn['renew_chart'] = $this->renewalChart($from, $to);
        }
        if ($request->has('new_file_chart')) {
            $from = $request->renew_chart['from'];
            $to = $request->renew_chart['to'];
            $rtn['new_file_chart'] = $this->newFIleChartV2($from, $to);
        }

        if ($request->has('file_category_chart')) {
            //            dd('here');
            $from = $request->renew_chart['from'];
            $to = $request->renew_chart['to'];
            $rtn['file_category_chart'] = $this->getNewJobsByType($from, $to);
        }
        if ($request->has('new_job_chart')) {
            $from = $request->renew_chart['from'];
            $to = $request->renew_chart['to'];
            $rtn['new_job_chart'] = $this->getNewJobsByTypeAndDate($from, $to);
        }
        if ($request->has('pra_table')) {

            $rtn['pra_table'] = $this->pradesheyasabaFileCount();
        }
        if ($request->has('env_officer_table')) {

            $rtn['env_officer_table'] = $this->environmentOfficerFileCount();
        }
        if ($request->has('industry_category_table')) {
            $from = $request->renew_chart['from'];
            $to = $request->renew_chart['to'];
            $rtn['industry_category_table'] = $this->industryCategoryFileCount();
        }
        if ($request->has('file_status_lable')) {

            $rtn['file_status_lable'] = $this->FileStatusFileCount();
        }
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $mytime = Carbon::now();
        $rtn["request_time"] = $mytime->toDateTimeString();
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    private function getEPlCountGroupMonth($data)
    {
        // dd($data->toArray());
        $group = $data->groupBy(function ($item, $key) {
            // dd($item);
            // dd(Carbon::parse($item['epl_submitted_date'])->format('m'));
            return Carbon::parse($item['epl_submitted_date'])->format('m');
        });
        $groupCount = $group->map(function ($item, $key) {
            return collect($item)->count();
        });
        $count = $groupCount->toArray();
        $count = refineArrayMonth($count);
        ksort($count);

        $count = array_values($count);
        // dd($count);
        return $count;
    }

    private function getSiteCountGroupMonth($data)
    {
        $group = $data->groupBy(function ($d) {
            return Carbon::parse($d->site_submit_date)->format('m');
        });
        $groupCount = $group->map(function ($item, $key) {
            return collect($item)->count();
        });
        $count = $groupCount->toArray();
        $count = refineArrayMonth($count);
        ksort($count);

        $count = array_values($count);
        // dd($d, $time_elapsed_secs);
        return $count;
    }

    private function getEPLExpireGroupMonth($data)
    {

        // dd($data->toArray());
        $group = $data->groupBy(function ($d) {
            return Carbon::parse($d->epl_expire_date)->format('m');
        });
        $groupCount = $group->map(function ($item, $key) {
            return collect($item)->count();
        });
        $count = $groupCount->toArray();
        $count = refineArrayMonth($count);
        ksort($count);

        $count = array_values($count);
        // dd($count);
        // dd($d, $time_elapsed_secs);
        return $count;
    }

    private function getSiteExpireGroupMonth($data)
    {
        $group = $data->groupBy(function ($d) {
            return Carbon::parse($d->site_expire_date)->format('m');
        });
        $groupCount = $group->map(function ($item, $key) {
            return collect($item)->count();
        });
        $count = $groupCount->toArray();
        $count = refineArrayMonth($count);
        ksort($count);

        $count = array_values($count);
        // dd($d, $time_elapsed_secs);
        // dd($count);
        return $count;
    }

    private function getMonths($from, $to)
    {
        $rtn = [];
        $start = (new DateTime($from))->modify('first day of this month');
        $end = (new DateTime($to))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            array_push($rtn, $dt->format("M"));
            // echo $dt->format("M") . "<br>\n";
        }
        return $rtn;
    }

    public function getNewJobsByTypeAndDate($from, $to)
    {
        $start = microtime(true);
        $rtn = [];
        $from = date('Y-m-d');
        $to = date('Y-m-d');

        $time = strtotime(date("Y-m-d"));
        $final = date("Y-m-d", strtotime("+1 day", $time));
        $from = date("Y-m-d");
        $to = $final;

        $eplCount = EPL::whereBetween('submitted_date', [$from, $to])
            // ->where('count', 0)
            ->count();

        $siteClearanceCount = SiteClearance::with('siteClearenceSession')->whereBetween('submit_date', [$from, $to])
            ->whereHas('siteClearenceSession', function ($query) {
                $query->where('site_clearance_type', 'Site Clearance');
            })
            // ->where('count', 0)
            ->count();

        $siteClearanceTeleCount = SiteClearance::with('siteClearenceSession')->whereBetween('submit_date', [$from, $to])
            ->whereHas('siteClearenceSession', function ($query) {
                $query->where('site_clearance_type', 'Telecommunication');
            })
            // ->where('count', 0)
            ->count();

        $types = array("EPL", "Site Clearance", "Tele Communication", "Schedule Waste");

        $scheduleWaste = 0;

        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["types"] = $types;
        $rtn["count"] = array($eplCount, $siteClearanceCount, $siteClearanceTeleCount, $scheduleWaste);
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }
}
