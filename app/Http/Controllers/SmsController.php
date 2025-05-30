<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Client;
use App\EPL;
use App\Helpers\SmsHelper;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        $client_details = Client::find($request->client_id);
        $epl = EPL::where('client_id', $client_details->id)->orderBy('created_at', 'desc')->first();
        $tel_no = preg_replace('/^\+?1|\|1|\D/', '', ($client_details->contact_no));

        $sms_message = 'ඔබගේ ' . $epl->code . ' අංක දරණ පරිසර ආරක්ෂණ බලපත්‍රය 20 ' . $request->expire_date . ' වන දින කල් ඉකුත් විමට නියමිතව ඇත.' . "\n" . 'එය අළුත් කිරිමට අයදුම්පත්‍රයක් ඉදිරිපත් කරන මෙන් කාරුණිකව ඉල්ලා සිටිමි.' . "\n" . 'දැනටමත් එය සිදුකර ඇත්නම් මෙය නොසලකන ලෙසද දැනුම් දෙමි.' . "\n"
            . 'වයඹ පළාත් පරිසර අධිකාරිය' . "\n" . '(Provincial  Environmental Authority-NWP)' . "\n" . '037-2225236' . "\n" . '(This is a system generated message)';

        if (isset($request->PhoneNumber)) {
            SmsHelper::sendSms($tel_no, $sms_message);
            return array('status' => 1, 'mesg' => 'SMS successfully sent');
        } else {
            return array('status' => 2, 'mesg' => 'No telephone number found');
        }
    }

    /**
     * send test sms
     */
    public function sendTestSms(Request $request)
    {
        // dd($request->all());
        $tel_no = preg_replace('/^\+?1|\|1|\D/', '', ($request->PhoneNumber));
        $sms_message = $request->message;

        if (isset($request->PhoneNumber)) {
            SmsHelper::sendSms($tel_no, $sms_message);
            return array('status' => 1, 'mesg' => 'SMS successfully sent');
        } else {
            return array('status' => 2, 'mesg' => 'No telephone number found');
        }

        // return  SmsHelper::sendSms($tel_no, $sms_message);
    }
}
