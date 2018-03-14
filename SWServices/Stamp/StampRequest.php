<?php 

namespace SWServices\Stamp;
use Exception;
class StampRequest{
    public static function sendReq($url, $token, $xml, $version, $proxy){
        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xml
                )
            );

        $data = '';
        // populate file fields
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            // "filename" attribute is not essential; server-side scripts may use it
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
            ' filename="' . $name . '"' . "\r\n";
            // this is, again, informative only; good practice to include though
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            // this endline must be here to indicate end of headers
            $data .= "\r\n";
            // the file itself (note: there's no encoding of any kind)
            $data .= $file['content'] . "\r\n";
        }
        // last delimiter
        $data .= "--" . $delimiter . "--\r\n";

        $curl  = curl_init($url.'/cfdi33/stamp/'.$version);
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
        } else {
            return json_decode($response);
        }
    }


    public static function sendReqB64($url, $token, $xml, $version){
        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'xml' => array(
                'type' => 'text/xml',
                'content' => $xml
                )
            );

        $data = '';
        // populate file fields
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            // "filename" attribute is not essential; server-side scripts may use it
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
            ' filename="' . $name . '"' . "\r\n";
            // this is, again, informative only; good practice to include though
            $data .= 'Content-Type: ' . $file['type'] . "\r\n";
            // this endline must be here to indicate end of headers
            $data .= "\r\n";
            // the file itself (note: there's no encoding of any kind)
            $data .= $file['content'] . "\r\n";
        }
        // last delimiter
        $data .= "--" . $delimiter . "--\r\n";

        $curl  = curl_init($url.'/cfdi33/stamp/'.$version.'/b64');
        curl_setopt($curl , CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl , CURLOPT_POST, true);
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