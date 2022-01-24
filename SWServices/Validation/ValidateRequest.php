<?php
namespace SWServices\Validation;

use SWServices\Services as Services;
use Exception;

class ValidateRequest{
    
 public static function sendReqXML($url, $token, $xml, $isB64, $proxy){
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

        $curl  = curl_init($url.'/validate/cfdi33'.($isB64?'/b64':''));
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        if(isset($proxy)){
            curl_setopt($curl , CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer '.$token
            ));  
        curl_setopt($curl , CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl );

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            return json_decode($response);
        }
    }
}

?>