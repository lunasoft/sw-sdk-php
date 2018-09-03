<?php 

namespace SWServices\Cancelation;
use SWServices\Cancelation\cancelationHandler as cancelationHandler;
use Exception;
class CancelationRequest{

    public static function sendReqUUID($url, $token, $rfc, $uuid, $proxy, $service, $action = null){
        $curl  = curl_init($url.$service.$rfc.'/'.$uuid."/".$action);
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
    
    public static function sendReqPFX($url, $token, $rfc, $uuid, $pfxB64, $password, $proxy, $service){
        $data = json_encode(array_merge($uuid,
                    [
                        "b64Pfx"=>$pfxB64,
                        "rfc"=>$rfc,
                        "password"=>$password,
                    ])
                );
        $curl  = curl_init($url.$service);
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
    
    public static function sendReqCSD($url, $token, $rfc, $uuid, $cerB64, $keyB64, $password, $proxy, $service) {
        $data = json_encode(array_merge($uuid,
                    [
                        "b64Key"=>$keyB64,
                        "b64Cer"=>$cerB64,
                        "rfc"=>$rfc,
                        "password"=>$password
                    ])
                );
        $curl  = curl_init($url.$service);
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
        // last delimiter
        $data .= "--" . $delimiter . "--\r\n";

        $curl  = curl_init($url.$service);
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
    
    public static function sendReqGet($url, $token, $rfc, $proxy, $service){       
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "$url.$service.$rfc",
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
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else{
            return json_decode($response);
        }
    }
    
    public static function soapRequest($rfcEmisor, $rfcReceptor, $total, $uuid){
        $request = new HttpRequest();
        $request->setUrl('https://consultaqr.facturaelectronica.sat.gob.mx/ConsultaCFDIService.svc?wdsl');
        $request->setMethod(HTTP_METH_POST);

        $request->setHeaders(array(
          'Postman-Token' => 'c05b3bc8-3038-4179-b32d-93a73e738a2e',
          'Cache-Control' => 'no-cache',
          'Authorization' => 'bearer T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbXB3YVZxTHdOdHAwVXY2NTdJb1hkREtXTzE3dk9pMmdMdkFDR2xFWFVPUXpTUm9mTG1ySXdZbFNja3FRa0RlYURqbzdzdlI2UUx1WGJiKzViUWY2dnZGbFloUDJ6RjhFTGF4M1BySnJ4cHF0YjUvbmRyWWpjTkVLN3ppd3RxL0dJPQ.T2lYQ0t4L0RHVkR4dHZ5Nkk1VHNEakZ3Y0J4Nk9GODZuRyt4cE1wVm5tbFlVcU92YUJTZWlHU3pER1kySnlXRTF4alNUS0ZWcUlVS0NhelhqaXdnWTRncklVSWVvZlFZMWNyUjVxYUFxMWFxcStUL1IzdGpHRTJqdS9Zakw2UGRiMTFPRlV3a2kyOWI5WUZHWk85ODJtU0M2UlJEUkFTVXhYTDNKZVdhOXIySE1tUVlFdm1jN3kvRStBQlpLRi9NeWJrd0R3clhpYWJrVUMwV0Mwd3FhUXdpUFF5NW5PN3J5cklMb0FETHlxVFRtRW16UW5ZVjAwUjdCa2g0Yk1iTExCeXJkVDRhMGMxOUZ1YWlIUWRRVC8yalFTNUczZXdvWlF0cSt2UW0waFZKY2gyaW5jeElydXN3clNPUDNvU1J2dm9weHBTSlZYNU9aaGsvalpQMUxrUndzK0dHS2dpTittY1JmR3o2M3NqNkh4MW9KVXMvUHhZYzVLQS9UK2E1SVhEZFJKYWx4ZmlEWDFuSXlqc2ZRYXlUQk1ldlZkU2tEdU10NFVMdHZKUURLblBxakw0SDl5bUxabDFLNmNPbEp6b3Jtd2Q1V2htRHlTdDZ6eTFRdUNnYnVvK2tuVUdhMmwrVWRCZi9rQkU9.7k2gVCGSZKLzJK5Ky3Nr5tKxvGSJhL13Q8W-YhT0uIo'
        ));

        try {
          $response = $request->send('
              <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
                <soapenv:Header/>
                <soapenv:Body>
                   <tem:Consulta>
                       <tem:expresionImpresa><![CDATA[?re=LSO1306189R5&rr=LSO1306189R5&tt=1.16&id=E0AAE6B3-43CC-4B9C-B229-7E221000E2BB]]></tem:expresionImpresa>
                   </tem:Consulta>
                </soapenv:Body>
             </soapenv:Envelope>');

          echo $response->getBody();
        } catch (HttpException $ex) {
          echo $ex;
        }
    }
}
?>