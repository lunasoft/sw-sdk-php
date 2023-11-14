<?php

namespace SWServices\AcceptReject;
use Exception;

class AcceptRejectRequest
{
    //AcceptReject - UUID
    public static function sendReqUUID($url, $token, $rfc, $uuid, $proxy, $service, $action)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "action" => $action ?? null
        ]);
        $curl = curl_init($url . $service . $rfc . '/' . $uuid . '/' . $action);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
            }
        }
    }

    //AcceptReject - CSD

    public static function sendReqCSD($url, $token, $rfc, $uuid, $cerB64, $keyB64, $password, $proxy, $service)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuids" => $uuid,
            "b64Cer" => $cerB64,
            "b64Key" => $keyB64,
            "password" => $password,
        ]);
        $curl = curl_init($url . $service);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
            }
        }
    }

    //AcceptReject - PFX
    public static function sendReqPFX($url, $token, $rfc, $uuids, $pfxB64, $password, $proxy, $service)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuids" => $uuids,
            "b64Pfx" => $pfxB64,
            "password" => $password,
        ]);
        $curl = curl_init($url . $service);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                throw new Exception("cUrl Error, HTTPCode: $httpcode, Response: $response");
            }
        }
    }

    //AcceptReject - XML
    public static function sendReqXML($url, $token, $xml, $proxy, $service)
    {
        $delimiter = '-------------' . uniqid();
        $fileFields = [
            'xml' => [
                'type' => 'text/xml',
                'content' => $xml
            ]
        ];
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
        $curl = curl_init($url . $service);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
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