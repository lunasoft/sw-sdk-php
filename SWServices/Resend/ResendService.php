<?php

namespace SWServices\Resend;
require_once 'SWServices/Resend/ResendRequest.php';

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
     * @param array $email Array de correos en formato string. (Max. 5).
     */
    public static function ResendEmail($uuid, $email){
        return ResendRequest::postResendEmail($uuid, $email);
    }
}
?>