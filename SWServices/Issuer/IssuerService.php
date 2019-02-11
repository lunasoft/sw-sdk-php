<?php
namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;

class EmisionTimbrado extends Services{
    public static function Set($params){
        return new EmisionTimbrado($params);
    }
        
    public static function EmisionTimbradoV1($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }
     public static function EmisionTimbradoV2($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }
     public static function EmisionTimbradoV3($xml, $isb64 = false){ 
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }
     public static function EmisionTimbradoV4($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/issue/');
    }

    public static function EmisionTimbradoVersion2V1($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
     public static function EmisionTimbradoVersionV2($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
     public static function EmisionTimbradoVersionV3($xml, $isb64 = false){ 
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
     public static function EmisionTimbradoVersionV4($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/v2/issue/');
    }
}

?>