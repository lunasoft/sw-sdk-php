<?php
namespace SWServices\Authentication;
use Exception;

class AuthRequest{
    public static function sendReq($url, $pass, $user,$proxy){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . "/security/authenticate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                 "cache-control: no-cache",
                "password: ". $pass,
                "user: " . $user,
                "Content-length: 0"
            ),
        ));
        if(isset($proxy)){
            curl_setopt($curl , CURLOPT_PROXY, $proxy);
        }
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            return json_decode($response);
        }
      
    }
}


?>