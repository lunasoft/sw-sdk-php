<?php

namespace SWServices\JSonIssuer;

use SWServices\Services as Services;
use SWServices\JSonIssuer\JsonIssuerRequest as jsonIssuerRequest;
use SWServices\JSonIssuer\JsonIssuerHelper as jsonIssuerHelper;

class JsonEmisionTimbrado extends Services
{
    public function __construct($params) {
        parent::__construct($params);
    }
    public static function Set($params){
        return new JsonEmisionTimbrado($params);
    }

    public static function jsonEmisionTimbradoV1($json, $isb64 = false){
        return  jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v1", $isb64, Services::get_proxy());
    }
     public static function jsonEmisionTimbradoV2($json, $isb64 = false){
        return  jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v2", $isb64, Services::get_proxy());
    }

     public static function jsonEmisionTimbradoV3($json, $isb64 = false){
        return  jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v3", $isb64, Services::get_proxy());
    }
     public static function jsonEmisionTimbradoV4($json, $isb64 = false){
        return  jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v4", $isb64, Services::get_proxy());
    }

    // Emisión Timbrado JSON V4

    /**
     * Servicio que consume el timbrado V4 que envia un customId y regresa la version V1 de respuesta que regresa el TFD (Timbre Fiscal Digital)
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param bool $pdf indica si se requiere la generación del PDF, por default es false
     * 
     * @return jsonIssuerRequest
     * 
     */

    public static function jsonIssueV4CustomIdPdfV1($json, $customId, $pdf = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v1", $helper::validate_customid($customId), $pdf, NULL, "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }

    /**
     * Servicio que consume el timbrado V4 que envia un customId y regresa la version V2 de respuesta que regresa el TFD (Timbre Fiscal Digital) y el CFDI timbrado.
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param bool $pdf indica si se requiere la generación del PDF, por default es false
     * 
     * @return jsonIssuerRequest
     * 
     */

    public static function jsonIssueV4CustomIdPdfV2($json, $customId, $pdf = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v2", $helper::validate_customid($customId), $pdf, NULL, "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }

    /**
     * Servicio que consume el timbrado V4 que envia un customId y regresa la version V3 de respuesta que regresa el CFDI timbrado.
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param bool $pdf indica si se requiere la generación del PDF, por default es false
     * 
     * @return jsonIssuerRequest
     * 
     */

    public static function jsonIssueV4CustomIdPdfV3($json, $customId, $pdf = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v3", $helper::validate_customid($customId), $pdf, NULL, "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }

    /**
     * Servicio que consume el timbrado V4 que envia un customId y regresa la version V4 de respuesta que regresa todos los datos del timbrado.
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param bool $pdf indica si se requiere la generación del PDF, por default es false
     * 
     * @return jsonIssuerRequest
     * 
     */

    public static function jsonIssueV4CustomIdPdfV4($json, $customId, $pdf = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v4", $helper::validate_customid($customId), $pdf, NULL, "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }

    /**
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, genera el PDF y lo adjunta al mismo envio de correo, retorna la version V1 de respuesta que regresa el TFD (Timbre Fiscal Digital)
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param string/array $email correo o arreglo de correos electrónicos a los que se enviará el resultado de la petición
     * 
     * @return jsonIssuerRequest
     * 
     */

    public static function jsonIssueV4CustomIdEmailV1($json, $customId, $email = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v1", $helper::validate_customid($customId), false, $helper::validate_email($email), "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }
    
    /**
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, genera el PDF y lo adjunta al mismo envio de correo, retorna la version V2 de respuesta que regresa el TFD (Timbre Fiscal Digital) y el CFDI timbrado.
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param string/array $email correo o arreglo de correos electrónicos a los que se enviará el resultado de la petición
     * 
     * @return jsonIssuerRequest
     */

    public static function jsonIssueV4CustomIdEmailV2($json, $customId, $email = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v2", $helper::validate_customid($customId), false, $helper::validate_email($email), "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }

    /**
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, genera el PDF y lo adjunta al mismo envio de correo, retorna la version V3 de respuesta que regresa el CFDI timbrado.
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param string/array $email correo o arreglo de correos electrónicos a los que se enviará el resultado de la petición
     * 
     * @return jsonIssuerRequest
     */

    public static function jsonIssueV4CustomIdEmailV3($json, $customId, $email = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v3", $helper::validate_customid($customId), false, $helper::validate_email($email), "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }

    /**
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, genera el PDF y lo adjunta al mismo envio de correo, retorna la version V4 de respuesta que regresa todos los datos del timbrado.
     * 
     * @param string $json a timbrar
     * @param string $customId identificador personalizado
     * @param string/array $email correo o arreglo de correos electrónicos a los que se enviará el resultado de la petición
     * 
     * @return jsonIssuerRequest
     */

    public static function jsonIssueV4CustomIdEmailV4($json, $customId, $email = false){
        $helper = new jsonIssuerHelper();
        return  jsonIssuerRequest::sendReqJsonV4(Services::get_url(), Services::get_token(), $json, "v4", $helper::validate_customid($customId), false, $helper::validate_email($email), "/v4/cfdi33/issue/json/",  Services::get_proxy());
    }


}


?>