<?php 

namespace SWServices\Stamp;
use Exception;
class StampRequestV4{
    public static function sendReqV4($url, $token, $xml, $version, $isb64, $proxy, $path, $customId, $customIdValue, $pdf, $email, $emailAddress){ //12 Parametros
        //Agregar condicionales para los headers que se reciben.
         $pdf = ($pdf == false)?NULL:"'extra: pdf',";
         $email = ($email == false)?NULL:"'email: ".$emailAddress."',";
         $customId = ($customId == false)?NULL:"customid: ".$customIdValue."',";
        //Se terminan las condicionales para determinar los headers que se envian.

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

        $curl  = curl_init($url.$path.$version.($isb64?'/b64':''));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
        if(isset($proxy)){
            curl_setopt($curl , CURLOPT_PROXY, $proxy);
        }
        
        curl_setopt($curl , CURLOPT_HTTPHEADER , array(
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer '.$token,
            $customId.$pdf.$email
            ));  
        curl_setopt($curl , CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl );
        curl_close($curl );

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
