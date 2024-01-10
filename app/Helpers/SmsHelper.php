<?php

namespace App\Helpers;

use GuzzleHttp;

class SmsHelper
{
    /**
     * Send SMS using Lankabell SMS Gateway HTTP API
     *
     * @param string $mobileNumber
     * @param string $message
     * @return bool $isSent
     */
    public static function sendSms($mobileNumber, $message)
    {
        $number = preg_replace('/^\+?1|\|1|\D/', '', $mobileNumber);

        if (strlen(trim($number)) == 0) {
            return false;
        }

        //SEND GET REQUEST TO SMS API
        $url = config('sms.http.url');
        $smsKey = config('sms.http.sms_key');
        $mask = config('sms.http.mask');
        // https://e-sms.dialog.lk/api/v1/message-via-url/create/url-campaign?esmsqk=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MTI0OTksImlhdCI6MTcwNDg3MTcyNiwiZXhwIjo0ODI5MDc0MTI2fQ.ykSOOUw2YBzjKoEhEygdkJfgSqtqo2enI4mCF7vZ6dM&list=0704655577,0743609669&source_address=PEA NWP&message=test sms
        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', $url, [
            'query' => [
                'esmsqk' => $smsKey,
                'list' => $number,
                'source_address' => $mask,
                'message' => $message,
            ]
        ]);

        $responseBody = json_decode($response->getBody());
        // $status = $responseBody->status;
        dd($responseBody);
        // $data = array(
        //     'SmsMessage' => $message,
        //     'PhoneNumber' => $number,
        //     'CompanyId' => config('sms.http.company_id'),
        //     'Pword' => config('sms.http.password'),
        // );

        // $json_data = json_encode($data);
        // $url = config('sms.http.url');
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($ch);
        // curl_close($ch);

        // $smsResult = json_decode($result);

        // if (isset($smsResult->Status) && $smsResult->Status != "200") {
        //     return false;
        // } else {
        //     return true;
        // }
    }
}
