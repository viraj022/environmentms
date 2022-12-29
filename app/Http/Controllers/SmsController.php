<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Client;
use App\EPL;

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
            $data = array(
                'SmsMessage' => $sms_message,
                'PhoneNumber' => $tel_no,
                'CompanyId' => 'CEYTECHAPI394',
                'Pword' => 'aQyp7glqK0',
            );

            $json_data = json_encode($data);
            $ch = curl_init('http://smsm.lankabell.com:4040/Sms.svc/PostSendSms');
            // Attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

            // Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

            // Return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute the POST request
            $result = curl_exec($ch);

            // Close cURL resource
            curl_close($ch);
            return array('status' => 1, 'mesg' => 'SMS successfully sent');
        } else {
            return array('status' => 2, 'mesg' => 'No telephone number found');
        }
    }
}
