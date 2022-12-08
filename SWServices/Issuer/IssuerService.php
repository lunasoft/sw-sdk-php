<?php
namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;
use SWServices\Stamp\StampHelper as StampHelper;


class EmisionTimbrado extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }
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
    //Timbrado V4 Issue 

    public static function stampV4CustomIdPdfV1($xml, $customId, $pdf = false ,$isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdPdfV2($xml, $customId, $pdf = false, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdPdfV3($xml, $customId, $pdf = false, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdPdfV4($xml, $customId, $pdf = false, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), $pdf, NULL);
    }
    public static function stampV4CustomIdEmailV1($xml, $customId, $email, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId,
            "email" => $email
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
    public static function stampV4CustomIdEmailV2($xml, $customId, $email, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId,
            "email" => $email
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
    public static function stampV4CustomIdEmailV3($xml, $customId, $email, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId,
            "email" => $email
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
    public static function stampV4CustomIdEmailV4($xml, $customId, $email, $isb64 = false){
        $params = array(
            "xml" => $xml,
            "customId" => $customId,
            "email" => $email
        );  
        $helper = new StampHelper($params);
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/issue/', $helper::validate_customid($customId), true, $helper::validate_email($email));
    }
}
