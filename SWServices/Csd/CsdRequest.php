<?php 

namespace SWServices\Csd;
use Exception;
class CsdRequest{
    public static function uploadCsdRequest($url, $token, $isActive, $certificateType, $cerB64, $keyB64, $password, $proxy, $service) {
        $data = json_encode(array_merge(
                    [
                        "is_active"=>$isActive,
                        "certificate_type"=>$certificateType,
                        "b64Key"=>$keyB64,
                        "b64Cer"=>$cerB64,
                        "password"=>$password
                    ])
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
            return json_decode($response);
        }
    }  
}
?>