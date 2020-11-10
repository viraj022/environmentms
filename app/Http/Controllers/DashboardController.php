<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\SiteClearance;
use App\ApplicationType;
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
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return view('dashboard', ['pageAuth' => $pageAuth]);
    }

    public function renewalChart($from, $to)
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->allPlain($from, $to);
        $eplCount = $this->getEPlCountGroupMonth($data->whereBetween('epl_submitted_date', [$from, $to])->where('epl_count', '>', '0'));
        $siteCount = $this->getSiteCountGroupMonth($data->whereBetween('site_submit_date', [$from, $to])->where('site_count', '>', '0'));
        $newCount = getArraySum($eplCount, $siteCount);

        $expireEPL = $this->getEPLExpireGroupMonth($data->whereBetween('epl_expire_date', [$from, $to]));
        $expireSITE = $this->getSiteExpireGroupMonth($data->whereBetween('site_expire_date', [$from, $to]));
        $expireCount = getArraySum($expireEPL, $expireSITE);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($siteCount, $eplCount, $newCount);
        $rtn["renew"] = $newCount;
        $rtn["expire"] = $expireCount;
        $rtn["months"] = $this->getMonths($from, $to);
        $rtn["time"] = $time_elapsed_secs;

        return $rtn;
    }

    public function newFIleChart($from, $to)
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->allPlain($from, $to);
        // dd($data->last()->toArray());
        $eplCount = $this->getEPlCountGroupMonth($data->whereBetween('epl_submitted_date', [$from, $to])->where('epl_count', '0'));
        $siteCount = $this->getSiteCountGroupMonth($data->whereBetween('site_submit_date', [$from, $to])->where('site_count', '0'));
        // dd($data->whereBetween('epl_submitted_date', [$from, $to])->where('epl_count', '0'));
        // dd($eplCount, $siteCount);
        $newCount = getArraySum($eplCount, $siteCount);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["new"] = $newCount;
        $rtn["months"] = $this->getMonths($from, $to);
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
        $client = new ClientRepository();
        $data = $client->allPlain($from, $to);
        $types = array("EPL", "Site Clearance", "Tele Communication", "Schedule Waste");
        $eplCount = $data->whereBetween('epl_submitted_date', [$from, $to])->count();
        $siteCount = $data->whereBetween('site_submit_date', [$from, $to])
            ->where('site_clearance_type', SiteClearance::SITE_CLEARANCE)
            ->count();
        $siteTeleCount = $data->whereBetween('site_submit_date', [$from, $to])
            ->where('site_clearance_type', SiteClearance::SITE_TELECOMMUNICATION)
            ->count();
        $scheduleWaste = 0;
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["types"] = $types;
        $rtn["count"] = array($eplCount, $siteCount, $siteTeleCount, $scheduleWaste);
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
            $rtn['new_file_chart'] = $this->newFIleChart($from, $to);
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
            $rtn['new_job_chart'] = $this->getNewJobsByType($from, $to);
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
}
