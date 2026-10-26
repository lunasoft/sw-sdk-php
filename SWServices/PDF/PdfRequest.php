<?php

namespace SWServices\PDF;

use SWServices\Helpers\CurlHelper;
use SWServices\Services;

use Exception;

class PdfRequest
{
    public static function sendReqGenerate($urlApi, $token, $xml, $logo, $templateId, $extras)
    {

        $data = json_encode(
            array(
                "xmlContent" => $xml,
                "logo" => $logo,
                "templateId" => $templateId,
                "extras" => $extras
            )
        );

        $headers = [
            'Content-Type: application/json;  ',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ];

        $curl = curl_init($urlApi . '/pdf/v1/api/GeneratePdf');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        CurlHelper::applySslOptions($curl, Services::get_ssl_options());
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $urlApi, false);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }
}
