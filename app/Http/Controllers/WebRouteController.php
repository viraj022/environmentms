<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SiteClearenceSession;
use App\Committee;
use App\Client;

class WebRouteController extends Controller {

    public function __construct() {
        $this->middleware(['auth']);
    }

    public function indexCommittee($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $siteclear = SiteClearenceSession::findOrFail($id);
        $client = Client::find($siteclear->client_id);
        return view('committee', ['pageAuth' => $pageAuth, 'id' => $id, 'client' => $siteclear->client_id, 'file_no' => $client->file_no]);
    }

    public function indexCommitteeRemarks($id) {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $commetteu = Committee::findOrFail($id);
        $client = Client::find($commetteu->client_id);
        return view('committee_remarks', ['pageAuth' => $pageAuth, 'id' => $id, 'client' => $commetteu->client_id, 'file_no' => $client->file_no,'name' => $commetteu->name,'ses_id' => $commetteu->site_clearence_session_id]);
    }

}
