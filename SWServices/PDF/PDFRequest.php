<?php
namespace SWServices\PDF;

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
        $curl = curl_init($urlApi . '/pdf/v1/api/GeneratePdf');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json;  ',
                'Content-Length: ' . strlen($data),
                'Authorization: Bearer ' . $token
            )
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
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
?>