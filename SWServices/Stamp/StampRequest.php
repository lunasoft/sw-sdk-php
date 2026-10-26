<?php

namespace SWServices\Stamp;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;
use SWServices\Helpers\ResponseHelper as Response;
use SimpleXMLElement;
use Exception;
use PHPUnit\Framework\Constraint\IsEqual;
use SWServices\Helpers\ResponseHelper;

class StampRequest
{
    public static function sendReq($url, $token, $xml, $version, $isB64, $proxy, $path)
    {

        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xml
            )
        );
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

        $curl = curl_init($url . $path . rawurlencode((string)$version) . ($isB64 ? '/b64' : ''));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        if (isset($proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl, [], 120);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
        }
    }
    public static function sendReqV4($url, $token, $xml, $version, $isb64, $proxy, $path, $customId, $pdf, $email)
    {
        //Esto genera el string junto con la variable que se recibe para generar CURLOPT_HTTPHEADER
        $pdf = ($pdf == false) ? NULL : "'extra: pdf',";
        $email = implode(',', (array) $email);
        $email = ($email == NULL) ? NULL : "'email: " . $email . "'";
        $customId = "customid: " . $customId . "',";

        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xml
            )
        );
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

        $curl = curl_init($url . $path . rawurlencode((string)$version) . ($isb64 ? '/b64' : ''));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        if (isset($proxy)) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token . '',
            $customId . $pdf . $email
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl, [], 120);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: " . CurlHelper::truncateResponse($response));
        }
    }
}