<?php

namespace SWServices\Csd;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use Exception;

class CsdRequest
{
    private static function sendRequest($url, $token, $proxy, $service, $method, $data = null)
    {


        // Service paths already contain the identifiers supplied by CsdService.
        $service = preg_replace_callback('#^(/certificates/(rfc|type)/)(.*)$#s', function ($matches) {
            $segments = $matches[2] === 'rfc' ? explode('/', $matches[3], 2) : [$matches[3]];
            return $matches[1] . implode('/', array_map('rawurlencode', $segments));
        }, $service, -1, $encoded);
        if (!$encoded && strpos($service, '/certificates/') === 0 && $service !== '/certificates/save') {
            $service = '/certificates/' . rawurlencode(substr($service, strlen('/certificates/')));
        }
        $path = $url . $service;

        $curl = curl_init($path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

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

        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);


        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cURL Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
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
