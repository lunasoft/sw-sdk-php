<?php
namespace SWServices\Stamp;

use SWServices\Services as Services;
use SWServices\Stamp\StampRequest as stampRequest;

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
    //Funcion que recibe unicamente el CustomId
    public static function StampV4CustomId($xml, $customId = true, $customIdValue){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, $customIdValue, false, false, NULL);
    }
    //Funcion que recibe el CustomId + generacion PDF
    public static function StampV4CustomPdf($xml, $customId = true, $customIdValue , $pdf = true){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, $customIdValue, true, false, NULL);
    }
    //Funcion que recibe el CustomId + envio de Email
    public static function StampV4CustomEmail($xml, $customId = true, $customIdValue , $email = true, $emailAddress){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', $customId, $customIdValue, false, true, $emailAddress);
    }
    //Funcion que genera solo el PDF
    public static function StampV4Pdf($xml, $pdf = true){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', false, NULL, true, false, NULL);
    }
    //Funcion que genera el PDF y lo envia por Email
    public static function StampV4PdfEmail($xml, $pdf = true, $email = true, $emailAddress){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', false, NULL, true, true, $emailAddress);
    }
    //Funcion que solo envia por Email
    public static function StampV4Email($xml, $email = true, $emailAddress){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', false, NULL, false, true, $emailAddress);
    }
    //Funcion que recibe el CustomID, Genera el Pdf y envia el Email
    public static function StampV4CustomPdfEmail($xml, $customId = true, $customIdValue, $pdf = true , $email = true, $emailAddress){
        return StampRequestV4::sendReqV4(Services::get_url(), Services::get_token(), $xml, "v4", $isB64, Services::get_proxy(), '/v4/cfdi33/stamp/', true, $customIdValue, true, true, $emailAddress);
    }
}

?>