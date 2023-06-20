<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\EPL;
use App\Minute;
use App\Repositories\MinutesRepository;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;
use App\Repositories\UserNotificationsRepositary;
use GuzzleHttp\Psr7\HttpFactory;
use App\Helpers\SmsHelper;
use App\SiteClearenceSession;

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
            $fileTypeName = '';
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
                $epl = EPL::where('client_id', $file->id)->orderBy('created_at', 'desc')->first();
                $msgMsg = "ඔබගේ " . $epl->code . " අංක දරණ පාරිසරික නිරවුල් සහතිකයේ / පාරිසරික ආරක්ෂණ බලපත්‍රයේ වැඩ කටයුතු නිමව ඇති අතර, එය ලබා ගැනීමට අවශ්‍ය කටයුතු සිදුකරන මෙන් කාරුණිකව ඉල්ලා සිටිමි.\n\nපාරිසරික ආරක්ෂණ බලපත්‍රයක් නම්,අදාල බලපත්‍ර ගාස්තු පිළිබඳව 037-2225236  දුරකථන අංකය මාර්ගයෙන් විමසීමට කටයුතු කරන ලෙසද දන්වා සිටිමි.\n\nවයඹ පළාත් පරිසර අධිකාරිය (Provincial  Environmental Authority-NWP)\n037-2225236\n(This is a system generated message)";
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
                $sc = SiteClearenceSession::where('client_id', $file->id)->orderBy('created_at', 'desc')->first();
                $msgMsg = "ඔබගේ " . $sc->code . " අංක දරණ පාරිසරික නිරවුල් සහතිකයේ / පාරිසරික ආරක්ෂණ බලපත්‍රයේ වැඩ කටයුතු නිමව ඇති අතර, එය ලබා ගැනීමට අවශ්‍ය කටයුතු සිදුකරන මෙන් කාරුණිකව ඉල්ලා සිටිමි.\n\nපාරිසරික ආරක්ෂණ බලපත්‍රයක් නම්,අදාල බලපත්‍ර ගාස්තු පිළිබඳව 037-2225236  දුරකථන අංකය මාර්ගයෙන් විමසීමට කටයුතු කරන ලෙසද දන්වා සිටිමි.\n\nවයඹ පළාත් පරිසර අධිකාරිය (Provincial  Environmental Authority-NWP)\n037-2225236\n(This is a system generated message)";
            }

            //send sms
            if ($file->contact_no != null) {
                SmsHelper::sendSms($file->contact_no, $msgMsg);
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
