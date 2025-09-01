<?php

namespace SWServices\CancelationRetention;

class CancelationRetentionHelper
{
    public static function buildMultipartXml($xmlContent, $boundary)
    {
        $multipart  = "--{$boundary}\r\n";
        $multipart .= 'Content-Disposition: form-data; name="xml"; filename="xml"' . "\r\n";
        $multipart .= "Content-Type: text/xml\r\n\r\n";
        $multipart .= (string)$xmlContent . "\r\n";
        $multipart .= "--{$boundary}--\r\n";
        return $multipart;
    }

    public static function decodeResponse($response, $httpCode)
    {
        $decoded = json_decode($response);
        if (json_last_error() === JSON_ERROR_NONE && is_object($decoded)) {
            return $decoded;
        }

        $status = ($httpCode >= 200 && $httpCode < 300);
        return (object)[
            'status'   => $status ? 'success' : 'error',
            'data'     => $status ? $response : null,
            'message'  => $status ? null : 'Respuesta no JSON',
            'httpCode' => $httpCode
        ];
    }

    public static function fromCurlError($err, $httpCode = 0)
    {
        return (object)[
            'status'   => 'error',
            'message'  => 'cURL: ' . $err,
            'data'     => null,
            'httpCode' => $httpCode
        ];
    }

    public static function fromHttpError($err, $httpCode)
    {
        return (object)[
            'status'   => 'error',
            'message'  => 'cURL: ' . $err,
            'data'     => null,
            'httpCode' => $httpCode
        ];
    }
}
