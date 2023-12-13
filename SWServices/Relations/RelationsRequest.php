<?php

namespace SWServices\Relations;

use SWServices\Relations\relationsHandler as RelationsHandler;
use Exception;

class RelationsRequest
{
    public static function sendReqCSDRelations($urlBase, $service, $token, $uuid, $password, $rfc, $cerB64, $keyB64)
    {
        $url = $urlBase . $service;
        $curl = curl_init();

        $data = array(
            'uuid' => $uuid,
            'password' => $password,
            'rfc' => $rfc,
            'b64Cer' => $cerB64,
            'b64Key' => $keyB64
        );

        $data_string = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                'Authorization: bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));

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
    public static function sendReqPFXRelations($urlBase, $service, $token, $uuid, $password, $rfc, $pfxB64)
    {
        $url = $urlBase . $service;
        $curl = curl_init();

        $data = array(
            'uuid' => $uuid,
            'password' => $password,
            'rfc' => $rfc,
            'b64pfx' => $pfxB64
        );

        $data_string = json_encode($data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                'Authorization: bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));

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
}
