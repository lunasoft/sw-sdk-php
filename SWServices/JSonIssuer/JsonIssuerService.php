<?php

namespace SWServices\JSonIssuer;

use SWServices\Services as Services;
use SWServices\JSonIssuer\JsonIssuerRequest as jsonIssuerRequest;

class JsonEmisionTimbrado extends Services{
    
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new JsonEmisionTimbrado($params);
    }
    public static function jsonEmisionTimbradoV1($json){
        return $isb64? 
                    jsonIssuerRequest::sendReqB64(Services::get_url(), Services::get_token(), $json, "v1",Services::get_proxy())
                : 
                    jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v1",Services::get_proxy());
    }
     public static function jsonEmisionTimbradoV2($json, $isb64 = false){
        return $isb64? 
                    jsonIssuerRequest::sendReqB64(Services::get_url(), Services::get_token(), $json, "v2",Services::get_proxy())
                : 
                    jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v2",Services::get_proxy());
    }

     public static function jsonEmisionTimbradoV3($json, $isb64 = false){
        return $isb64? 
                    jsonIssuerRequest::sendReqB64(Services::get_url(), Services::get_token(), $json, "v3",Services::get_proxy())
                : 
                    jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v3",Services::get_proxy());
    }
     public static function jsonEmisionTimbrado4($json, $isb64 = false){
        return $isb64? 
                    jsonIssuerRequest::sendReqB64(Services::get_url(), Services::get_token(), $json, "v4",Services::get_proxy())
                : 
                    jsonIssuerRequest::sendReq(Services::get_url(), Services::get_token(), $json, "v4",Services::get_proxy());
    }
}


?>