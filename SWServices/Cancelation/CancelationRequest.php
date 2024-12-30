<?php

namespace SWServices\Cancelation;

use SWServices\Cancelation\cancelationHandler as CancelationHandler;
use Exception;

class CancelationRequest
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

        $path = $url . $service . $rfc . '/' . $uuid . '/' . $motivo . '/' . ($foliosustitucion ?? '') . '/' . ($action ?? '');
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
            CURLOPT_URL => $url . $service . $rfc,
            CURLOPT_RETURNTRANSFER => true,
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
