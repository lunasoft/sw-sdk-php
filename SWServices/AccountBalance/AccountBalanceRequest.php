<?php

namespace SWServices\AccountBalance;

use Exception;

class AccountBalanceRequest
{
    const BALANCE_ENDPOINT = "/account/balance/";
    const MANAGEMENT_BALANCE_ENDPOINT = "/management/api/balance/";
    // Función privada para realizar solicitudes HTTP comunes
    private static function makeRequest($url, $token, $method = "GET", $data = null, $proxy = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data ? json_encode($data) : null,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "authorization: bearer $token",
            ),
        ));
        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
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
        $url = $urlService . self::BALANCE_ENDPOINT;
        return self::makeRequest($url, $token, "GET", null, $proxy);
    }
    // Método para obtener el Balance por UserId
    public static function getBalanceByIdRequest($urlApi, $token, $id, $proxy = null)
    {
        $url = $urlApi . self::MANAGEMENT_BALANCE_ENDPOINT . $id;
        return self::makeRequest($url, $token, "GET", null, $proxy);
    }
    // Método para añadir o eliminar timbres a una cuenta
    public static function distributionStampRequest($urlApi, $token, $action, $id, $stamps, $comment = null, $proxy = null)
    {
        $url = $urlApi . self::MANAGEMENT_BALANCE_ENDPOINT . "$id/$action/$stamps";
        $postData = $comment !== null ? array("Comentario" => $comment) : null;

        return self::makeRequest($url, $token, "POST", $postData, $proxy);
    }
}
?>