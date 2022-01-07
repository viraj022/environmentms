<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class ResetSettingsController extends Controller {

    public function index() {
        return view('ResetSettings');
    }

    public function get_epl_site_count() {
        $epl = Setting::where('name', 'epl_ai')->first();
        $site = Setting::where('name', 'site_ai')->first();

        return array("epl_count" => $epl->value, "site_count" => $site->value);
    }

    public function reset_site_counts() {
        $epl_updated = false;
        $site_updated = false;
        
        $epl = Setting::where('name', 'epl_ai')->first();
        $site = Setting::where('name', 'site_ai')->first();

        $is_epl_outdated = $epl->updated_at->format('Y');
        $is_site_outdated = $site->updated_at->format('Y');

        if ($is_epl_outdated != date("Y")) {
            $epl->value = 1;
            $epl_updated = $epl->save();
        }

        if ($is_epl_outdated != date("Y")) {
            $site->value = 1;
            $site_updated = $site->save();
        }

        if ($epl_updated == true || $site_updated == true) {
            return array('status' => 1, 'msg' => 'Successfully reset the epl and site counts');
        } else {
            return array('status' => 0, 'msg' => 'Resetting is unsuccessful');
        }
    }

}
