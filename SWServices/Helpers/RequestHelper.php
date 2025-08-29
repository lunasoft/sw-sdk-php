<?php

namespace SWServices\Helpers;

require_once 'SWServices/Helpers/ResponseHelper.php';

use Exception;

class RequestHelper extends ResponseHelper
{
    /**
     * Internal method for make a Post Request with a Json Body, It supports a custom Content-Type.
     */
    protected static function postJson($url, $path, $token, $data, $proxy, $contentType = "application/json")
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'Authorization: Bearer ' . $token
        ];

        $curl  = curl_init($url . $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSLVERSION, $protocols);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ResponseHelper::toErrorResponse("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return ResponseHelper::toErrorResponse("cUrl Error, HTTPCode: $httpcode", $response);
            }
        }
    }
    /**
     *Método interno para construir un request POST con parámetros en path.
     */
    protected static function PostPath($url, $path, $token, $proxy)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $curl  = curl_init($url . $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLVERSION, $protocols);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        (isset($proxy)) ? curl_setopt($curl, CURLOPT_PROXY, $proxy) : "";

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ResponseHelper::toErrorResponse("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return ResponseHelper::toErrorResponse("cUrl Error, HTTPCode: $httpcode", $response);
            }
        }
    }
    /**
     * Método interno para construir un Request génerico con datos en el Jsonbody (opcional)
     */
    public static function sendRequest($url, $requestMethod, $path, $token, $data = null, $proxy = null)
    {
        $protocols = [
            CURL_SSLVERSION_TLSv1_2,
            CURL_SSLVERSION_TLSv1_3
        ];

        $curl = curl_init();

        $options = array(
            CURLOPT_URL => $url . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => $protocols,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $requestMethod,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "authorization: bearer " . $token,
            ),
        );

        if ($data !== null) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
            $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
            $options[CURLOPT_HTTPHEADER][] = 'Content-Length: ' . strlen(json_encode($data));
        }

        if (isset($proxy)) {
            $options[CURLOPT_PROXY] = $proxy;
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        curl_close($curl);

        //Provicional para manejo de creación de usuarios
        if ($httpcode == "204" && strpos($path, '/management/v2/api/dealers/users/') !== false && $requestMethod == "DELETE"){
            $lastSegment = substr($path, strrpos($path, '/') + 1);
            if (!empty($lastSegment)) {
                $response .= json_encode(array(
                    "status" => "success",
                    "message" => "Usuario eliminado con éxito"
                ));
            }
        }

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            if ($httpcode < 500) {
                return json_decode($response);
            } else {
                return ResponseHelper::toErrorResponse("cUrl Error, HTTPCode: $httpcode", $response);
            }
        }
    }
}
