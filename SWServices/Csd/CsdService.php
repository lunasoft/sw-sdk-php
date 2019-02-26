<?php
namespace SWServices\Csd;

use SWServices\Csd\CsdRequest as csdRequest;
use SWServices\Services as Services;
use Exception;

class CsdService extends Services {
    public function __construct($params) {
        parent::__construct($params);
    }
    
    public static function Set($params){
        return new CsdService($params);
    }
        
    public static function UploadCsd($isActive, $certificateType, $cerB64, $keyB64, $password) {
        return csdRequest::uploadCsdRequest(Services::get_url(), Services::get_token(), $isActive, $certificateType, $cerB64, $keyB64, $password, Services::get_proxy(), '/certificates/save');
    }

    public static function GetListCsd() {
        return csdRequest::GetCsdRequest(Services::get_url(), Services::get_token(), Services::get_proxy(), '/certificates');
    }
    public static function GetListCsdByType($type) {
        return csdRequest::GetCsdRequest(Services::get_url(), Services::get_token(), Services::get_proxy(), "/certificates/type/$type");
    }
    public static function GetListCsdByRfc($rfc) {
        return csdRequest::GetCsdRequest(Services::get_url(), Services::get_token(), Services::get_proxy(), "/certificates/rfc/$rfc");
    }
    public static function InfoCsd($certificateNumber) {
        return csdRequest::GetCsdRequest(Services::get_url(), Services::get_token(), Services::get_proxy(), "/certificates/$certificateNumber");
    }
    public static function InfoActiveCsd($rfc, $type) {
        return csdRequest::GetCsdRequest(Services::get_url(), Services::get_token(), Services::get_proxy(), "/certificates/rfc/$rfc/$type");
    }
    public static function DisableCsd($certificateNumber) {
        return csdRequest::DisableCsdRequest(Services::get_url(), Services::get_token(), Services::get_proxy(), "/certificates/$certificateNumber");
    }
}
?>