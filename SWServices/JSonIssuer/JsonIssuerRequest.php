<?php 

namespace SWServices\JSonIssuer;
use Exception;


class JsonIssuerRequest{
   
    
  public static function sendReq($url, $token, $json, $version, $isB64, $proxy){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $url."/v3/cfdi33/issue/json/".$version.($isB64?'/b64':''),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $json,
      CURLOPT_HTTPHEADER => array(
        "Authorization: bearer ".$token,
        "Content-Type: application/jsontoxml"
      ),
    ));

    if(isset($proxy)){
           curl_setopt($curl , CURLOPT_PROXY, $proxy);
       }
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
}
?>