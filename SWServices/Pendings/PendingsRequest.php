<?php

namespace SWServices\Pendings;

use Exception;

class PendingsRequest
{
    public static function sendReqGet($url, $token, $rfc, $proxy, $service)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url . $service . $rfc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSLVERSION => $protocols,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: bearer " . $token,
                "Cache-Control: no-cache"
            ],
        ]);

        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
            }
        }
    }
}
