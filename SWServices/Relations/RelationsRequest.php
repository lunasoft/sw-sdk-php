<?php

namespace SWServices\Relations;

use Exception;

class RelationsRequest
{
    public static function sendRequest($url, $token, $data = null, $headers = [], $proxy = null, $method = 'POST')
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSLVERSION => $protocols,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
        ]);

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        $defaultHeaders = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #: " . $err);
        }

        if ($httpcode < 500) {
            return json_decode($response);
        } else {
            throw new Exception("cURL Error, HTTPCode: $httpcode, Response: $response");
        }
    }

    public static function sendReqCSDRelations($url, $service, $token, $uuid, $password, $rfc, $cerB64, $keyB64, $proxy = null)
    {
        $data = json_encode([
            'uuid' => $uuid,
            'password' => $password,
            'rfc' => $rfc,
            'b64Cer' => $cerB64,
            'b64Key' => $keyB64
        ]);

        $path = $url . $service;
        $headers = ['Content-Type: application/json'];

        return self::sendRequest($path, $token, $data, $headers, $proxy);
    }

    public static function sendReqPFXRelations($url, $service, $token, $uuid, $password, $rfc, $pfxB64, $proxy = null)
    {
        $data = json_encode([
            'uuid' => $uuid,
            'password' => $password,
            'rfc' => $rfc,
            'b64pfx' => $pfxB64
        ]);

        $path = $url . $service;
        $headers = ['Content-Type: application/json'];

        return self::sendRequest($path, $token, $data, $headers, $proxy);
    }

    public static function sendReqUUID($url, $service, $token, $rfc, $uuid, $proxy = null)
    {
        $path = $url . $service . $rfc . '/' . $uuid;

        return self::sendRequest($path, $token, null, [], $proxy);
    }
}
