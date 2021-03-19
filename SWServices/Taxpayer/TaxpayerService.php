<?php

namespace SWServices\Taxpayer;

use SWServices\Taxpayer\TaxpayerRequest as TaxpayerRequest;
use SWServices\Services as Services;
use Exception;

class TaxpayerService extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new TaxpayerService($params);
    }
    
    public static function GetTaxpayer($rfc){
        return TaxpayerRequest::sendReq(Services::get_url(), Services::get_token(), $rfc, Services::get_proxy());
    }
}
?>