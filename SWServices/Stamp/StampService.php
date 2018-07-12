<?php

namespace SWServices\Stamp;


use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;


class Timbrado extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new Timbrado($params);
    }
    public static function TimbradoV1($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy());
    }
     public static function TimbradoV2($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy());
    }

     public static function TimbradoV3($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy());
    }
     public static function TimbradoV4($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy());
    }
}


?>