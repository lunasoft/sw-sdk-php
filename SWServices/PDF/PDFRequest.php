<?php

namespace SWServices\PDF;

use Exception;

class PdfRequest
{
    public static function sendReqGenerate($urlApi, $token, $xml, $logo, $templateId, $extras)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

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
        curl_setopt($curl, CURLOPT_SSLVERSION, $protocols);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
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
