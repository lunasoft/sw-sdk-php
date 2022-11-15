<?php 

namespace SWServices\Helpers;
use Exception;

class RequestHelper extends ResponseHelper {
    /**
     * Internal method for make a Post Request with a Json Body, It supports a custom Content-Type.
     */
    protected static function PostJson($url, $path, $token, $data, $contentType = "application/json"){
        $curl  = curl_init($url . $path);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
       (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Content-Type: ' . $contentType,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer '.$token
            ));  
        curl_setopt($curl , CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl);

        if ($err) {
            return ResponseHelper::ToErrorResponse("cURL Error #:" . $err);
        } else {
            if($httpcode < 500) {
                return json_decode($response);
            }
            else {
                return ResponseHelper::ToErrorResponse("cUrl Error, HTTPCode: $httpcode", $response);
            }       
        }
    }
}
