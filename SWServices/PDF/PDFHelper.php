<?php

namespace SWServices\PDF;
use Exception;

class PdfHelper
{
    private static $xml = null;
    private static $_response = null;
    private static $_urlApi = null;


    public function __construct($params)
    {

        if (!empty($params['urlApi'])) {
            self::$_urlApi = $params['urlApi'];
        } else {
            echo 'URL API debe especificarse', "\n";
        }
        if (!empty($params['xml'])) {
            self::$xml = $params['xml'];


        } else {
            echo 'xml null o inválido', "\n";
        }
    }


    public static function get_urlApi()
    {
        return self::$_urlApi;
    }
    public static function get_response($response)
    {
        return self::$_response = $response;

    }
    public static function get_xml($isB64)
    {
        try {

            if ($isB64 == false) {
                return self::$xml;

            } else {
                return base64_decode(self::$xml);
            }

        } catch (Exception $e) {
            echo 'xml no válido', $e->getMessage(), "\n";
        }


    }

};