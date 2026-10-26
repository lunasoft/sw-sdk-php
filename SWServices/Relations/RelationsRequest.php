<?php

namespace SWServices\Relations;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use Exception;

class RelationsRequest
{
    public static function sendRequest($url, $token, $data = null, $headers = [], $proxy = null, $method = 'POST')
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
        ]);

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } elseif (strtoupper((string)$method) === 'POST') {
            // Sin cuerpo, cURL no envía Content-Length y el servicio responde 411.
            curl_setopt($curl, CURLOPT_POSTFIELDS, '');
        }

        $defaultHeaders = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));

        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $url, $data === null && strtoupper((string)$method) === 'GET');
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);


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
        $path = $url . $service . rawurlencode((string)$rfc) . '/' . rawurlencode((string)$uuid);

        return self::sendRequest($path, $token, null, [], $proxy);
    }
}
