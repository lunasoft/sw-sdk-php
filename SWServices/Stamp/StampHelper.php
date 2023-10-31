<?php

namespace SWServices\Stamp;

use Exception;

class StampHelper
{
    private static $xml = null;
    private static $_response = null;
    private static $_urlApi = null;
    private static $customId = null;
    private static $email = null;

    public static function get_xml($isB64)
    {
        try {

            if ($isB64 == false) {
                return self::validate_xml(self::$xml);
            } else {
                return self::validate_xml(base64_decode(self::$xml));
            }
        } catch (Exception $e) {
            echo 'xml no válido', $e->getMessage();
            exit();
        }
    }
    public static function validate_xml($xml)
    {
        if (!empty($xml)) {
            return $xml;
        } else {
            echo 'si responde con el resultado';
            exit();
        }
    }
    public static function validate_customid($customId)
    {
        try {
            if ($customId != NULL || $customId != "") {
                return $customId;
            }
        } catch (Exception $e) {
            echo 'customId viene vacio', $e->getMessage();
            exit();
        }
    }
    public static function validate_email($email)
    {
        try { //Revisar funcionalidad del helper solo falta este cambio para concretar el ejercicio
            if ((count(array($email)) <= 5) && (count(array($email)) > 0)) {
                $eResult = true;
                foreach ((array) $email as $valor) {
                    $validEmail = (filter_var($valor, FILTER_VALIDATE_EMAIL));
                    if ($validEmail == false) {
                        $eResult = false;
                    }
                }
            }
            if ($eResult == false) {
                echo "Error";
                var_dump($email);
                exit();
            } else {
                return $email;
            }
        } catch (Exception $e) {
            echo 'recepcion de email invalido', $e->getMessage();
            exit();
        }
    }
};
