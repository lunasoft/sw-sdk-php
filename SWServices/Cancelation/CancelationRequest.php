<?php

namespace SWServices\Cancelation;

use SWServices\Cancelation\cancelationHandler as CancelationHandler;
use Exception;

class CancelationRequest
{
    public static function sendReqCSD($url, $token, $rfc, $uuid, $motivo, $cerB64, $keyB64, $password, $proxy, $service, $foliosustitucion = null)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "motivo" => $motivo,
            "b64Cer" => $cerB64,
            "b64Key" => $keyB64,
            "password" => $password,
            "foliosustitucion" => $foliosustitucion ?? null
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
    public static function sendReqUUID($url, $token, $rfc, $uuid, $motivo, $proxy, $service, $foliosustitucion = null, $action = null)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "motivo" => $motivo,
            "foliosustitucion" => $foliosustitucion ?? null,
            "action" => $action ?? null
        ]);
        $curl = curl_init($url . $service . $rfc . '/' . $uuid . '/' . $motivo . '/' . $foliosustitucion . '/' . $action);
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
    public static function sendReqPFX($url, $token, $rfc, $uuid, $motivo,  $pfxB64, $password, $proxy, $service, $foliosustitucion = null)
    {
        $data = json_encode([
            "rfc" => $rfc,
            "uuid" => $uuid,
            "motivo" => $motivo,
            "b64Pfx" => $pfxB64,
            "password" => $password,
            "foliosustitucion" => $foliosustitucion ?? null
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
    public static function sendReqGet($url, $token, $rfc, $proxy, $service)
    {
        $curl = curl_init();
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        curl_setopt_array($curl, [
            CURLOPT_URL => $url . $service . $rfc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: bearer " . $token,
                "Cache-Control: no-cache"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
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
}