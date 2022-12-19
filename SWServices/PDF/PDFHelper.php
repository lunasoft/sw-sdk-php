<?php

namespace SWServices\PDF;

use Exception;


/*Clase para las funciones de ayuda
para los servicios PDF*/

class PdfHelper
{
    private static $xml = null;


    public function __construct($params)
    {
        if (!empty($params['xml'])) {
            self::$xml = $params['xml'];
        }
    }
    public static function getXml($isB64)
    {
        try {

            if ($isB64 == false) {
                return self::validateXml(self::$xml);
            } else {
                return self::validateXml(base64_decode(self::$xml));
            }
        } catch (Exception $e) {
            echo 'xml vacio o no es válido.', $e->getMessage();
            exit();
        }
    }
    private static function validateXml($xml)
    {
        if (!empty($xml)) {
            return $xml;
        } else {
            throw new Exception();
        }
    }
    /**
     * Función para validar uuid null.
     * @param string $uuid Folio del comprobante.
     * @return bool
     */
    public static function validateUuid($uuid)
    {
        if (!empty($uuid)) {
            return true;
        } else {
            throw new Exception("UUID vacío o es inválido");
        }
    }
};
