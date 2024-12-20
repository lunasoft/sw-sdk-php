<?php

namespace SWServices\AccountBalance;

use Exception;

class AccountBalanceRequest
{
    private static function sendRequest($url, $token, $method, $data = null, $headers = [], $proxy = null)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => $protocols,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
        ));
        
        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        $defaultHeaders = [
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error: $err");
        } elseif ($httpcode >= 500) {
            throw new Exception("cURL Error, HTTPCode: $httpcode, Response: $response");
        }
        return json_decode($response);
    }

    // Método para obtener el Balance por token
    public static function getBalanceByTokenRequest($urlService, $token, $proxy = null)
    {
        $url = $urlService . "/management/v2/api/users/balance";
        return self::sendRequest($url, $token, "GET", null, [], $proxy);
    }
    // Método para añadir o eliminar timbres a una cuenta
    public static function distributionStampRequest($urlApi, $token, $action, $id, $stamps, $comment = null, $proxy = null)
    {
        $url = $urlApi . "/management/v2/api/dealers/users/$id/stamps";
        $headers = ['Content-Type: application/json'];

        $data = ["stamps" => $stamps];

        if ($comment !== null) {
            $data["comment"] = $comment;
        }

        return self::sendRequest($url, $token, $action, json_encode($data), $headers, $proxy);
    }
}
