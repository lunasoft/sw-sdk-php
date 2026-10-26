<?php

namespace SWServices\Validation;

use SWServices\Helpers\CurlHelper;

use SWServices\Services as Services;
use Exception;

class ValidateRequest
{

    public static function sendReqXML($url, $token, $xml, $status, $proxy)
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

        $path = $url . '/validate/cfdi' . ($status == false ? '?' . http_build_query(['validatestatus' => 'false']) : '');

        $curl  = curl_init($path);
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
        CurlHelper::applyTimeoutOptions($curl);
        CurlHelper::applyRedirectOptions($curl, $url, false);
        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            return json_decode($response);
        }
    }
}
