<?php

namespace SWServices\AcceptReject;

use Exception;

class AcceptRejectRequest
{
    private static function sendRequest($url, $token, $method, $data, $headers = [], $proxy = null)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLVERSION, $protocols);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        $defaultHeaders = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error: " . $err);
        }

        if ($httpcode >= 500) {
            throw new Exception("HTTP Error: $httpcode. Response: $response");
        }

        return json_decode($response);
    }


    //AcceptReject - UUID
    public static function sendReqUUID($url, $token, $rfc, $uuid, $proxy, $service, $action)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "action" => $action ?? null
        ]);

        $path = $url . $service . $rfc . '/' . $uuid . '/' . $action;
        $headers = ['Content-Type: application/json'];
        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }

    //AcceptReject - CSD

    public static function sendReqCSD($url, $token, $rfc, $uuid, $cerB64, $keyB64, $password, $proxy, $service)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuids" => $uuid,
            "b64Cer" => $cerB64,
            "b64Key" => $keyB64,
            "password" => $password,
        ]);

        $path = $url . $service;
        $headers = ['Content-Type: application/json'];
        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }

    //AcceptReject - PFX
    public static function sendReqPFX($url, $token, $rfc, $uuids, $pfxB64, $password, $proxy, $service)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuids" => $uuids,
            "b64Pfx" => $pfxB64,
            "password" => $password,
        ]);

        $data = json_encode([
            "rfc" => $rfc,
            "uuids" => $uuids,
            "b64Pfx" => $pfxB64,
            "password" => $password,
        ]);

        $path = $url . $service;
        $headers = ['Content-Type: application/json'];

        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }

    //AcceptReject - XML
    public static function sendReqXML($url, $token, $xml, $proxy, $service)
    {
        $delimiter = '-------------' . uniqid();
        $fileFields = [
            'xml' => [
                'type' => 'text/xml',
                'content' => $xml
            ]
        ];
        $data = '';
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
                ' filename="' . $name . '"' . "\r\n";
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";
        $path = $url . $service;
        $headers = [
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data)
        ];

        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }
}
