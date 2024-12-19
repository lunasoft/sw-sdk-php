<?php

namespace SWServices\Authentication;

use Exception;

class AuthRequest
{
    public static function sendReq($url, $pass, $user, $proxy)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $data = json_encode([
            "user" => $user,
            "password" => $pass
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/v2/security/authenticate",
            CURLOPT_SSLVERSION => $protocols,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        if (isset($proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }
}
