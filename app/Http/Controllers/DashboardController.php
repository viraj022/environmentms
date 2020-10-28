<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientRepository;

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
        $rtn = [];
        $start = microtime(true);
        $client = new ClientRepository();
        $data = $client->allPlain($from, $to);
        $eplCount = $this->getEPlCountGroupMonth($data);
        $siteCount = $this->getSiteCountGroupMonth($data);
        $newCount = getArraySum($eplCount, $siteCount);

        $expireEPL = $this->getEPLExpireGroupMonth($data);
        $expireSITE = $this->getSiteExpireGroupMonth($data);
        $expireCount =   getArraySum($expireEPL, $expireSITE);
        $time_elapsed_secs = round(microtime(true) - $start, 5);
        // dd($siteCount, $eplCount, $newCount);
        $rtn["renew"] = $newCount;
        $rtn["expire"] = $expireCount;
        $rtn["time"] = $time_elapsed_secs;
        return $rtn;
    }


    public function getDashboardData(Request $request)
    {
        return  $this->renewalChart('2020-10-01', '2020-10-30');
        $rtn = [];
        if ($request->type = 'renewal_chart') {
        }

        return $rtn;
    }

    private function getEPlCountGroupMonth($data)
    {
        $group =  $data->groupBy(function ($d) {
            return Carbon::parse($d->epl_submitted_date)->format('m');
        });
        $groupCount = $group->map(function ($item, $key) {
            return collect($item)->count();
        });
        $count = $groupCount->toArray();
        ksort($count);
        $count = refineArrayMonth($count);

        $count = array_values($count);
        // dd($d, $time_elapsed_secs);
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
        ksort($count);
        $count = refineArrayMonth($count);

        $count = array_values($count);
        // dd($d, $time_elapsed_secs);
        return $count;
    }
    private function getEPLExpireGroupMonth($data)
    {
        $group =  $data->groupBy(function ($d) {
            return Carbon::parse($d->epl_expire_date)->format('m');
        });
        $groupCount = $group->map(function ($item, $key) {
            return collect($item)->count();
        });
        $count = $groupCount->toArray();
        ksort($count);
        $count = refineArrayMonth($count);

        $count = array_values($count);
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
        ksort($count);
        $count = refineArrayMonth($count);

        $count = array_values($count);
        // dd($d, $time_elapsed_secs);
        return $count;
    }
}
