<?php

namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;

class EmisionTimbrado extends stampRequest{

    function __construct() {
      parent::setPath('/cfdi33/issue/');
    }
    
    public static function Set($params){
        return new EmisionTimbrado($params);
    }
    public static function EmisionTimbradoV1($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy());
    }
     public static function EmisionTimbradoV2($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy());
    }
     public static function EmisionTimbradoV3($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy());
    }
     public static function EmisionTimbradoV4($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy());
    }
}

?>