<?php

namespace SWServices\Cancelation;


use SWServices\Cancelation\CancelationRequest as cancelationRequest;
use SWServices\Services as Services;
use Exception;

class CancelationService extends Services {

    public function __construct($params) {
        parent::__construct($params);
    }
    
    public static function Set($params){
        return new CancelationService($params);
    }
        
    public static function CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid) {
        return cancelationRequest::sendReqCSD(Services::get_url(), Services::get_token(), $rfc, $cerB64, $keyB64, $password, $uuid, Services::get_proxy());
    }

    public static function CancelationByXML($xml) {
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy());
    }
    
    public static function CancelationByUUID($rfc, $uuid){
        return cancelationRequest::sendReqUUID(Services::get_url(), Services::get_token(), $rfc, $uuid, Services::get_proxy());
    }
    
    public static function CancelationByPFX($rfc, $pfxB64, $password, $uuid){
        return cancelationRequest::sendReqPFX(Services::get_url(), Services::get_token(), $rfc, $pfxB64, $password, $uuid, Services::get_proxy());
    }
}
?>