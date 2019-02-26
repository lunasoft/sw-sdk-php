<?php 

namespace SWServices\Cancelation;
use SWServices\Cancelation\cancelationHandler as CancelationHandler;
use Exception;
class CancelationRequest{

    public static function sendReqUUID($url, $token, $rfc, $uuid, $proxy, $service, $action = null){
        $curl  = curl_init($url.$service.$rfc.'/'.$uuid."/".$action);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
        
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
            if($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }
    
    public static function sendReqPFX($url, $token, $rfc, $uuid, $pfxB64, $password, $proxy, $service){
        $data = json_encode(array_merge($uuid,
                    array(
                        "b64Pfx"=>$pfxB64,
                        "rfc"=>$rfc,
                        "password"=>$password,
                    ))
                );
        $curl  = curl_init($url.$service);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
        
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
            if($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }
    
    public static function sendReqCSD($url, $token, $rfc, $uuid, $cerB64, $keyB64, $password, $proxy, $service) {
        $data = json_encode(array_merge($uuid,
                    array(
                        "b64Key"=>$keyB64,
                        "b64Cer"=>$cerB64,
                        "rfc"=>$rfc,
                        "password"=>$password
                    ))
                );
        $curl  = curl_init($url.$service);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
       (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
       
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
            if($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }

    public static function sendReqXML($url, $token, $xml, $proxy, $service){
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

        $curl  = curl_init($url.$service);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
        
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
    
    public static function sendReqGet($url, $token, $rfc, $proxy, $service){       
        $curl = curl_init();
        (isset($proxy))?curl_setopt($curl , CURLOPT_PROXY, $proxy):"";
            
        curl_setopt_array($curl, array(    
            CURLOPT_URL => $url.$service.$rfc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "Authorization: bearer ".$token,
            "Cache-Control: no-cache"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            if($httpcode < 500)
                return json_decode($response);
            else
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
        }
    }    
}
?>