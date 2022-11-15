<?php
namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;
use SWServices\Stamp\StampHelper as StampHelper;

class StampService extends Services {
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new StampService($params);
    }
    public static function StampV1($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
    }
     public static function StampV2($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
    }
     public static function StampV3($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
    }
     public static function StampV4($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/stamp/');
    }

    public static function StampVersion2V1($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
    }
    public static function StampVersion2V2($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
    }
    public static function StampVersion2V3($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
    }
    public static function StampVersion2V4($xml, $isb64 = false){
        return stampRequest::sendReq(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/cfdi33/v2/stamp/');
    }
    //Funciones para timbrado V4
    //Modificar las funciones para las 4 versiones de repuesta y con la opcion pdf o email
    public static function StampV4CustomIdPdfV1($xml, $customId, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", NULL);
    }
    public static function StampV4CustomIdPdfV2($xml, $customId, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", NULL);
    }
    public static function StampV4CustomIdPdfV3($xml, $customId, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", NULL);
    }
    public static function StampV4CustomIdPdfV4($xml, $customId, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", NULL);
    }
    public static function StampV4CustomIdEmailV1($xml, $customId, $email, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v1", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", $email);
    }
    public static function StampV4CustomIdEmailV2($xml, $customId, $email, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v2", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", $email);
    }
    public static function StampV4CustomIdEmailV3($xml, $customId, $email, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v3", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", $email);
    }
    public static function StampV4CustomIdEmailV4($xml, $customId, $email, $isb64 = false){
        return stampRequest::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isb64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, "pdf", $email);
    }
}

?>