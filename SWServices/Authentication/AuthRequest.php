<?php
namespace SWServices\Authentication;

class AuthRequest{
    public static function sendReq($url, $pass, $user){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url . "/security/authenticate",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "password: ". $pass,
            "user: " . $user
        ),
        ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    echo $err;

    curl_close($curl);
    if ($err) {
    throw new Exception("cURL Error #:" . $err);
    } else {
        
    return json_encode($response);
    }
  
}
}


?>