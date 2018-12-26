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
        return csdRequest::uploadCsdRequest(Services::get_url(), Services::get_token(), $isActive, $certificateType, $cerB64, $keyB64, $password, Services::get_proxy(), '/csd/save');
    }
        
}
?>