<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Minute;
use App\Repositories\MinutesRepository;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;

class DirectorController extends Controller {

    public function __construct() {
        $this->middleware(['auth']);
    }

    public function DirectorFinalApprove(Request $request, MinutesRepository $minutesRepository, $file_id) {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
                    request()->validate([
                        'minutes' => 'sometimes|required|string',
                    ]);
                    $user = Auth::user();
                    $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
//                    dd($user);
                    $file = Client::findOrFail($file_id);
                    $msg = setFileStatus($file_id, 'file_status', 5);
                    $msg = setFileStatus($file_id, 'cer_status', 5);

                    fileLog($file->id, 'Approval', 'Director (' . $user->first_name . ' ' . $user->last_name . ') Approve the Certificate', 0);
                    LogActivity::addToLog('Director Approve the certificate', $file);
                    if ($request->has('minutes')) {
                        $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_Dire_APPROVE_CERTIFICATE, $user->id));
                    }
                    if ($msg) {
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                });
    }

}
