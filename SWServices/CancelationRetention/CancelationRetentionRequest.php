<?php

namespace SWServices\CancelationRetention;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

class CancelationRetentionRequest
{
    public static function cancelByXML($baseUrl, $token, $xmlContent)
    {
        $url = rtrim($baseUrl, '/') . '/retencion/cancel/xml';

        $boundary = '-------------' . uniqid();
        $body     = CancelationRetentionHelper::buildMultipartXml($xmlContent, $boundary);

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: multipart/form-data; boundary=' . $boundary,
            'Accept: application/json'
        ];

        return self::sendReq('POST', $url, $headers, $body);
    }

    public static function cancelByCSD($baseUrl, $token, array $data)
    {
        $url = rtrim($baseUrl, '/') . '/retencion/cancel/csd';

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $body = json_encode($data);
        return self::sendReq('POST', $url, $headers, $body);
    }

    public static function cancelByPFX($baseUrl, $token, array $data)
    {
        $url = rtrim($baseUrl, '/') . '/retencion/cancel/pfx';

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $body = json_encode($data);
        return self::sendReq('POST', $url, $headers, $body);
    }

    private static function sendReq($method, $url, array $headers, $body)
    {

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $body,
        ]);

        CurlHelper::applySslOptions($ch, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($ch);
        CurlHelper::applyRedirectOptions($ch, $url, false);
        $response = curl_exec($ch);
        $errNo    = curl_errno($ch);
        $errMsg   = curl_error($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($errNo) {
            return CancelationRetentionHelper::fromCurlError($errMsg, $httpCode);
        }

        $decoded = CancelationRetentionHelper::decodeResponse($response, $httpCode);

        if ($httpCode < 200 || $httpCode >= 300) {
            if (is_object($decoded) && property_exists($decoded, 'status')) {
                return $decoded;
            }

            return CancelationRetentionHelper::fromHttpError("HTTP $httpCode", $httpCode, $response);
        }

        return $decoded;
    }
}
