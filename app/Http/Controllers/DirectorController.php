<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Minute;
use App\Repositories\MinutesRepository;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;
use App\Repositories\UserNotificationsRepositary;

class DirectorController extends Controller
{

    private $userNotificationsRepositary;
    public function __construct(UserNotificationsRepositary $userNotificationsRepositary)
    {
        $this->userNotificationsRepositary = $userNotificationsRepositary;
    }

    public function DirectorFinalApprove(Request $request, MinutesRepository $minutesRepository, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            //                    dd($user);
            $file = Client::with('environmentOfficer')->whereId($file_id)->first();
            $msg = setFileStatus($file_id, 'file_status', 5);
            $msg = setFileStatus($file_id, 'cer_status', 5);

            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }

            fileLog($file->id, 'Approval', 'Director (' . $user->first_name . ' ' . $user->last_name . ') Approve the Certificate', 0, $fileTypeName, '');
            LogActivity::addToLog('Director Approve the certificate', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->assistantDirector->user_id,
                'Approved for"' . $file->industry_name . '"',
                $file_id
            );

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Approved for"' . $file->industry_name . '"',
                $file_id
            );

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
