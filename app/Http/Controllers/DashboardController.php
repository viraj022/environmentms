<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientRepository;
use App\Repositories\IndustryCategoryRepository;
use App\SiteClearance;
use App\SiteClearenceSession;

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
        $siteCount = $this->getSiteCountGroupMonth($data->whereBetween('site_submit_date', [$from, $to])->where('epl_count', '>', '0'));
        $newCount = getArraySum($eplCount, $siteCount);

        $expireEPL = $this->getEPLExpireGroupMonth($data->whereBetween('epl_expire_date', [$from, $to]));
        $expireSITE = $this->getSiteExpireGroupMonth($data->whereBetween('site_expire_date', [$from, $to]));
        $expireCount =   getArraySum($expireEPL, $expireSITE);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($siteCount, $eplCount, $newCount);
        $rtn["renew"] = $newCount;
        $rtn["expire"] = $expireCount;
        $rtn["time"] = $time_elapsed_secs;

        return $rtn;
    }
    public function newFIleChart($from, $to)
    {
        $start = microtime(true);
        $rtn = [];
        $client = new ClientRepository();
        $data = $client->allPlain($from, $to);
        $eplCount = $this->getEPlCountGroupMonth($data->whereBetween('epl_submitted_date', [$from, $to])->where('epl_count', '0'));
        $siteCount = $this->getSiteCountGroupMonth($data->whereBetween('site_submit_date', [$from, $to])->where('epl_count', '0'));
        $newCount = getArraySum($eplCount, $siteCount);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["new"] = $newCount;
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
        $types = array("EPL", "Site Clearance", "Schedule Waste", "Tele Communication", "Tele Communication");
        $eplCount = $data->whereBetween('epl_submitted_date', [$from, $to])->count();
        $siteCount = $data->whereBetween('site_submit_date', [$from, $to])
            ->where('site_clearance_type', SiteClearance::SITE_CLEARANCE)
            ->count();
        $siteTeleCount = $data->whereBetween('site_submit_date', [$from, $to])
            ->where('site_clearance_type', SiteClearance::SITE_TELECOMMUNICATION)
            ->count();
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        $rtn["types"] = $types;
        $rtn["count"] = array($eplCount, $siteCount);
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }

    public function getDashboardData(Request $request)
    {
        // $client = new ClientRepository();
        // return $client->all()->whereNotNull('site_code');
        return  $this->getNewJobsByType('2020-01-01', '2020-12-30');
        return  $this->IssueFileCategory('2020-01-01', '2020-12-30');
        return  $this->newFIleChart('2020-01-01', '2020-12-30');
        return  $this->renewalChart('2020-01-01', '2020-12-30');
        $rtn = [];
        if ($request->type = 'renewal_chart') {
        }

        return $rtn;
    }

    private function getEPlCountGroupMonth($data)
    {
        // dd($data->toArray());
        $group =  $data->groupBy(function ($item, $key) {
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
        $group =  $data->groupBy(function ($d) {
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
        $group =  $data->groupBy(function ($d) {
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
        $group =  $data->groupBy(function ($d) {
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
}
