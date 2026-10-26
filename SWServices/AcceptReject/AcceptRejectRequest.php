<?php

namespace SWServices\AcceptReject;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use Exception;

class AcceptRejectRequest
{
    private static function sendRequest($url, $token, $method, $data, $headers = [], $proxy = null)
    {

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        $defaultHeaders = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));

        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);


        if ($err) {
            throw new Exception("cURL Error: " . $err);
        }

        if ($httpcode >= 500) {
            throw new Exception("HTTP Error: $httpcode. Response: " . CurlHelper::truncateResponse($response));
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

        $path = $url . $service . rawurlencode((string)$rfc) . '/' . rawurlencode((string)$uuid) . '/' . rawurlencode((string)$action);
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
