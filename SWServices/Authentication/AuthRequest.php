<?php

namespace SWServices\Authentication;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use Exception;

class AuthRequest
{
    public static function sendReq($url, $pass, $user, $proxy)
    {

        $data = json_encode([
            "user" => $user,
            "password" => $pass
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/v2/security/authenticate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
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
        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
        }
    }
}
