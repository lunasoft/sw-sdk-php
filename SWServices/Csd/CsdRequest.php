<?php

namespace SWServices\Csd;

use Exception;

class CsdRequest
{
    private static function sendRequest($url, $token, $proxy, $service, $method, $data = null)
    {

        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $path = $url . $service;

        $curl = curl_init($path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLVERSION, $protocols);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        if (isset($proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        $headers = [
            'Authorization: Bearer ' . $token
        ];

        if ($method == 'POST') {
            $headers[] = 'Content-Type: application/json';
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } elseif ($method === 'GET') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        } elseif ($method === 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cURL Error, HTTPCode: $httpcode, Response: $response");
            }
        }
    }

    public static function uploadCsdRequest($url, $token, $isActive, $certificateType, $cerB64, $keyB64, $password, $proxy, $service)
    {
        $data = json_encode(
            array_merge(
                array(
                    "is_active" => $isActive,
                    "type" => $certificateType,
                    "b64Key" => $keyB64,
                    "b64Cer" => $cerB64,
                    "password" => $password
                )
            )
        );

        return self::sendRequest($url, $token, $proxy, $service, 'POST', $data);
    }

    public static function GetCsdRequest($url, $token, $proxy, $service)
    {
        return self::sendRequest($url, $token, $proxy, $service, 'GET');
    }

    public static function DisableCsdRequest($url, $token, $proxy, $service)
    {
        return self::sendRequest($url, $token, $proxy, $service, 'DELETE');
    }
}
