<?php

namespace SWServices\JSonIssuer;

use Exception;

class JsonIssuerHelper
{
    public static function validate_json($json)
    {
        if (!empty($json)) {
            return $json;
        } else {
            echo 'JSON no válido o vacío';
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
            echo 'CustomId viene vacio', $e->getMessage();
            exit();
        }
    }
    public static function validate_email($email)
    {
        try {
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
            echo 'Recepcion de email invalido', $e->getMessage();
            exit();
        }
    }
};
