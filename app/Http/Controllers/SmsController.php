<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Client;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        $client_details = Client::find($request->client_id);
        $tel_no = preg_replace('/^\+?1|\|1|\D/', '', ($client_details->contact_no));
        $sms_message = 'Obage ' . $client_details->industry_name . ' anka darana parisara arakshana balapathraya '."\n"
        .  $request->expire_date .' wana dina kal ikuth weemata niyamithawa etha.'."\n"
        . 'Ebawin balapathraya aluth kirima sadaha "parisarika '."\n"
        . 'arakshana balapathraya warshikawa aluth kirima ' ."\n"
        . 'sadaha wu illumpathraya"'."\n"
        .'idiripath karana men '."\n"
        .'kaarunikawa danwami.'."\n"
        .'Danatamath oba wisin'."\n"
        .'ayadumpathak idiripath kara'."\n"
        .'athnam meya nosalakaa harina men danwaa sitimi.'."\n"
        .'Wayamba Palath Parisara Adikariya'."\n"
        .'(Provicial Environment Authority-NWP)'."\n"
        .'037-2225236'."\n"
        .'(This is a system generated message)';

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
        return $result;
    }
}
