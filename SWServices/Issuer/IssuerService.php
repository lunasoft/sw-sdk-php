<?php

namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;
use SWServices\Stamp\StampHelper as StampHelper;


class EmisionTimbrado extends Services
{
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params)
    {
        return new EmisionTimbrado($params);
    }

    public static function EmisionTimbradoV1($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }
    public static function EmisionTimbradoV2($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }
    public static function EmisionTimbradoV3($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }
    public static function EmisionTimbradoV4($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }

    public static function EmisionTimbradoVersion2V1($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
    public static function EmisionTimbradoVersionV2($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
    public static function EmisionTimbradoVersionV3($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
    public static function EmisionTimbradoVersionV4($xml, $isb64 = false)
    {
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
    //Timbrado V4 Issue 

    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId y regresa con la version V1 de respuesta que regresa el TFD(Timbre Fiscal Digital)
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion, dentro de esta funcion esta false por defecto
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdPdfV1($xml, $customId, $pdf = false, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId y regresa con la version V2 de respuesta que regresa el TFD(Timbre Fiscal Digital) y el XML timbrado.
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion, dentro de esta funcion esta false por defecto
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdPdfV2($xml, $customId, $pdf = false, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId y regresa con la version V3 de respuesta que regresa el CFDI timbrado.
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion, dentro de esta funcion esta false por defecto
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdPdfV3($xml, $customId, $pdf = false, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId y regresa con la version V4 de respuesta que regresa todos los datos del timbrado
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion, dentro de esta funcion esta false por defecto
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdPdfV4($xml, $customId, $pdf = false, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }

    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, que genera el pdf y lo adjunta al mismo envio del correo
     * ademas regresa con la version V1 de respuesta que regresa el TFD(Timbre Fiscal Digital)
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param string/array $email Correo o correos electronicos al que se enviara el resultado de la peticion, maximo 5 correos en un arreglo.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion.
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdEmailV1($xml, $customId, $email, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, que genera el pdf y lo adjunta al mismo envio del correo
     * ademas regresa con la version V2 de respuesta que regresa el TFD(Timbre Fiscal Digital) y el CFDI timbrado.
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param string/array $email Correo o correos electronicos al que se enviara el resultado de la peticion, maximo 5 correos en un arreglo.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion.
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdEmailV2($xml, $customId, $email, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, que genera el pdf y lo adjunta al mismo envio del correo
     * ademas regresa con la version V3 de respuesta que regresa el CFDI timbrado.
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param string/array $email Correo o correos electronicos al que se enviara el resultado de la peticion, maximo 5 correos en un arreglo.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion.
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdEmailV3($xml, $customId, $email, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
    /**
     * 
     * Servicio que consume el timbrado V4 que envia un customId, un correo electronico o un arreglo de maximo 5 correos, que genera el pdf y lo adjunta al mismo envio del correo
     * ademas regresa con la version V4 de respuesta que regresa todos los datos del timbrado
     * 
     * @param string $xml documento a timbrar.
     * @param string $customId dato para determinar dato unico.
     * @param string/array $email Correo o correos electronicos al que se enviara el resultado de la peticion, maximo 5 correos en un arreglo.
     * @param bool $pdf variable que determina si se genera y adjunta el pdf en la peticion.
     * @param bool $isb64 variable que determina si se recibe el XML en base64.
     * 
     * @return stampRequest
     * 
     */
    public static function issueV4CustomIdEmailV4($xml, $customId, $email, $isb64 = false)
    {
        $helper = new StampHelper();
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
}
