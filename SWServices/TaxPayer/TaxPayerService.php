<?php

namespace SWServices\TaxPayer;

use SWServices\Taxpayer\TaxpayerRequest;
use SWServices\Services;

class TaxPayerService extends TaxPayerRequest{
    public function __construct($params) {
        parent::__construct($params);
    }
    /**
     * Inicializa Resend Service.
     */
    public static function Set($params){
        return new TaxpayerService($params);
    }
    /**
     * Servicio que verifica si un RFC se encuentra en la lista de EFOS.
     */
    public static function VerifyTaxPayer($rfc){
        return TaxpayerRequest::getTaxPayer(Services::get_url(), Services::get_token(), $rfc, Services::get_proxy());
    }
}