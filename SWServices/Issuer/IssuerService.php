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
     *  * @autor David Ernesto Reyes <david.reyes@sw.com.mx>
     *
     * @desde 1.0.7.1
     *
     * Servicio que consume el timbrado V4 que envia un customId, tambien que envia un correo con el XML y el pdf adjunto
     * El customId es un identificador unico que el cliente determina, al utilizar el envio de correo por default se genera
     * un pdf que se adjunta al mismo cuerpo del correo junto con el XML
     * 
     * 
     * 
     * @param xml $xml documento a timbrar.
     * @param customId $customId dato para determinar dato unico.
     * @param email $email Correo o correos electronicos al que se enviara el resultado de la peticion, maximo 5 correos en un arreglo.
     * @param pdf $pdf variable que determina si se genera y adjunta el pdf en la peticion.
     * 
     * @return stampRequest
     * 
     */
    //Instanciar StampRequest


    public static function stampV4CustomIdPdfV1($xml, $customId, $pdf = false, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdPdfV2($xml, $customId, $pdf = false, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdPdfV3($xml, $customId, $pdf = false, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdPdfV4($xml, $customId, $pdf = false, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), $pdf, NULL);
    }

    public static function stampV4CustomIdEmailV1($xml, $customId, $email, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), true, ($email));
    }
    public static function stampV4CustomIdEmailV2($xml, $customId, $email, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), true, ($email));
    }
    public static function stampV4CustomIdEmailV3($xml, $customId, $email, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), true, ($email));
    }
    public static function stampV4CustomIdEmailV4($xml, $customId, $email, $isb64 = false)
    {
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', ($customId), true, ($email));
    }
}
