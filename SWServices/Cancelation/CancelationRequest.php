<?php

namespace SWServices\Cancelation;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use SWServices\Cancelation\cancelationHandler as CancelationHandler;
use Exception;

class CancelationRequest
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

    public static function sendReqCSD($url, $token, $rfc, $uuid, $motivo, $cerB64, $keyB64, $password, $proxy, $service, $foliosustitucion = null)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "motivo" => $motivo,
            "b64Cer" => $cerB64,
            "b64Key" => $keyB64,
            "password" => $password,
            "foliosustitucion" => $foliosustitucion ?? null
        ]);

        $path = $url . $service;
        $headers = ['Content-Type: application/json'];

        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }

    public static function sendReqUUID($url, $token, $rfc, $uuid, $motivo, $proxy, $service, $foliosustitucion = null, $action = null)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "motivo" => $motivo,
            "foliosustitucion" => $foliosustitucion ?? null,
            "action" => $action ?? null
        ]);

        $path = $url . $service . rawurlencode((string)$rfc) . '/' . rawurlencode((string)$uuid) . '/' . rawurlencode((string)$motivo) . '/' . rawurlencode((string)($foliosustitucion ?? '')) . '/' . rawurlencode((string)($action ?? ''));
        $headers = ['Content-Type: application/json'];

        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }

    public static function sendReqPFX($url, $token, $rfc, $uuid, $motivo,  $pfxB64, $password, $proxy, $service, $foliosustitucion = null)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "motivo" => $motivo,
            "b64Pfx" => $pfxB64,
            "password" => $password,
            "foliosustitucion" => $foliosustitucion ?? null
        ]);
        
        $path = $url . $service;
        $headers = ['Content-Type: application/json'];
        
        return self::sendRequest($path, $token, 'POST', $data, $headers, $proxy);
    }

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
    
    public static function sendReqGet($url, $token, $rfc, $proxy, $service)
    {
        $curl = curl_init();
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        curl_setopt_array($curl, [
            CURLOPT_URL => $url . $service . rawurlencode((string)$rfc),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: bearer " . $token,
                "Cache-Control: no-cache"
            ],
        ]);
        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
            }
        }
    }
}
