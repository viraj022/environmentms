<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SmsController extends Controller
{
    public function send_sms(Request $request){

       $tel_no = preg_replace('/^\+?1|\|1|\D/', '', ($request->PhoneNumber));

        $data = array(
            'SmsMessage' => $request->SmsMessage,
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
        return $result;
    }
}
