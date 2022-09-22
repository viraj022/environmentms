<?php

namespace App\Helpers;

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

        $data = array(
            'SmsMessage' => $message,
            'PhoneNumber' => $number,
            'CompanyId' => config('sms.http.company_id'),
            'Pword' => config('sms.http.password'),
        );

        $json_data = json_encode($data);
        $url = config('sms.http.url');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $smsResult = json_decode($result);

        if ($smsResult->Status != "200") {
            return false;
        } else {
            return true;
        }
    }
}
