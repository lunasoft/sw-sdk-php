<?php 

namespace SWServices\Cancelation;
use Exception;
class CancelationRequest{

    public static function sendReqUUID($url, $token, $rfc, $uuid, $proxy){
        $curl  = curl_init($url.'/cfdi33/cancel/'.$rfc.'/'.$uuid);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        if(isset($proxy)){
            curl_setopt($curl , CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Content-Type: application/json;  ',
            'Authorization: Bearer '.$token
            ));  
        curl_setopt($curl , CURLOPT_POSTFIELDS, "");

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            return json_decode($response);
        }
    }
    
    public static function sendReqPFX($url, $token, $rfc, $pfxB64, $password, $uuid, $proxy){
        $data = json_encode(
                    [
                        "b64Pfx"=>$pfxB64,
                        "rfc"=>$rfc,
                        "password"=>$password,
                        "uuid"=>$uuid
                    ]
                );
        $curl  = curl_init($url.'/cfdi33/cancel/pfx');
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        if(isset($proxy)){
            curl_setopt($curl , CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Content-Type: application/json;  ',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer '.$token
            ));  
        curl_setopt($curl , CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            return json_decode($response);
        }
    }
    
    public static function sendReqCSD($url, $token, $rfc, $cerB64, $keyB64, $password, $uuid, $proxy) {
        $data = json_encode(
                    [
                        "b64Key"=>$keyB64,
                        "b64Cer"=>$cerB64,
                        "rfc"=>$rfc,
                        "password"=>$password,
                        "uuid"=>$uuid
                    ]
                );
        $curl  = curl_init($url.'/cfdi33/cancel/csd');
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        if(isset($proxy)){
            curl_setopt($curl , CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Content-Type: application/json;  ',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer '.$token
            ));  
        curl_setopt($curl , CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            return json_decode($response);
        }
    }

    public static function sendReqXML($url, $token, $xml, $proxy){
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
        // last delimiter
        $data .= "--" . $delimiter . "--\r\n";

        $curl  = curl_init($url.'/cfdi33/cancel/xml');
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