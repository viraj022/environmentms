<?php

namespace App\Http\Controllers;

use App\WarningLetter;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class WarningLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('warning_letter', ['pageAuth' => $pageAuth]);
    }

    public function warnLetView($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $warn_letter = WarningLetter::where('id', $id)->with('client.certificates', 'client.industryCategory', 'client.epls')->first();
        // dd($warn_letter);
        $address = explode(',', $warn_letter->client->address);
        $certificate_count = count($warn_letter->client->certificates);

        $lastEpl = $warn_letter->client->epls->last();
        $exp_date = CarbonCarbon::parse($lastEpl->expire_date)->format('Y-m-d');
        // dd($exp_date);
        $cert_no = '';
        if ($certificate_count > 0) {
            $LastCertificate = $warn_letter->client->certificates->last();
            $exp_date = (empty($warn_letter->expire_date)) ? $LastCertificate->expire_date : $warn_letter->expire_date;
            $cert_no = $LastCertificate->cetificate_number;
        }
        // dd($cert_no);
        return view('warn_letter_view', ['pageAuth' => $pageAuth, 'warn_let_data' => $warn_letter, 'client_address' => $address, 'expire_date' => $exp_date, 'cert_no' => $cert_no]);
    }
    public function warningLetterLog()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $warn_letter = WarningLetter::with('client.industryCategory')->get();
        return view('Reports.warning_letter_log', ['pageAuth' => $pageAuth, 'warn_let_data' => $warn_letter]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $current_date = Carbon::parse(date("Y-m-d"));
        $expired_date = Carbon::parse($request->expired_date);
        $user = Auth::user()->id;
        $client_id = $request->client_id;
        $expired_days = $current_date->diffInDays($expired_date);
        $file_type = $request->file_type;

        $warning_letter = WarningLetter::create([
            "user_id" => $user,
            "client_id" => $client_id,
            "expired_days" => $expired_days,
            "file_type" => $file_type,
            "expire_date" => $expired_date->format('Y-m-d'),
        ]);
        dd($warning_letter);

        if ($warning_letter == true) {
            return array('status' => 1, 'message' => 'Successfully saved the warning letter');
        } else {
            return array('status' => 0, 'message' => 'Warning letter saving is unsuccessful');
        }
    }
}
