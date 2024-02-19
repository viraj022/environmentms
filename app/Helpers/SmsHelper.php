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
        $client = new GuzzleHttp\Client();


        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'esmsqk' => $smsKey,
                    'list' => $number,
                    'source_address' => $mask,
                    'message' => $message,
                ]
            ]);

            // Check if the response status code is 200 (OK)
            if ($response->getStatusCode() === 200) {
                $responseBody = json_decode($response->getBody());

                return $responseBody;
            } else {
                // Log the status code and reason for failure
                error_log('SMS sending failed with status code: ' . $response->getStatusCode());
                return false;
            }
        } catch (GuzzleHttp\Exception\RequestException $e) {
            // Log the error
            error_log('Request failed: ' . $e->getMessage());
            return false;
        }
    }
}
