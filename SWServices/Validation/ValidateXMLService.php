<?php

namespace SWServices\Validation;
use SWServices\Services as Services;
use SWServices\Validation\ValidateRequest as ValidateRequest;
use Exception;

class ValidateXMLService extends Services{
       
    public function __construct($params) {
        parent::__construct($params);
    }
    
   public static function Set($params){
        return new ValidateXMLService($params);
    }
    
    public static function ValidaXML($xml, $status = true){
        return ValidateRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, $status, Services::get_proxy());
    }    
}

?>
