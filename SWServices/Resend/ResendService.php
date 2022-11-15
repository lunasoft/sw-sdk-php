<?php

namespace SWServices\Resend;

class ResendService extends ResendRequest {
    public function __construct($params)
    {
        parent::__construct($params);
    }
    /**
     * Inicializa Resend Service.
     */
    public static function Set($params){
        return new ResendService($params);
    }
    /**
     * Servicio que realiza el reenvio de correo de un UUID previamente timbrado.
     * @param string $uuid Folio del comprobante.
     * @param string $email Correo o listado de correos delimitados por comas (Max. 5). 
     */
    public static function ResendEmail($uuid, $email){
        return ResendRequest::PostResendEmail($uuid, $email);
    }
}
?>