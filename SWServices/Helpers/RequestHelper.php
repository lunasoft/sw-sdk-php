<?php

namespace SWServices\Helpers;
require_once 'SWServices/Helpers/ResponseHelper.php';

use Exception;

class RequestHelper extends ResponseHelper
{
    /**
     * Internal method for make a Post Request with a Json Body, It supports a custom Content-Type.
     */
    protected static function postJson($url, $path, $token, $data, $proxy, $contentType = "application/json")
    {
        $curl  = curl_init($url . $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: ' . $contentType,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ResponseHelper::toErrorResponse("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return ResponseHelper::toErrorResponse("cUrl Error, HTTPCode: $httpcode", $response);
            }
        }
    }
    /**
     *Método interno para construir un request POST con parámetros en path.
     */
    protected static function PostPath($url, $path, $token, $proxy){
        $curl  = curl_init($url . $path);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_HTTPGET, true);
        (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
        
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Authorization: Bearer '.$token
            ));  

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl);

        if ($err) {
            return ResponseHelper::toErrorResponse("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return ResponseHelper::toErrorResponse("cUrl Error, HTTPCode: $httpcode", $response);
            }
        }
    }
}
