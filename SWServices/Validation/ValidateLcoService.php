<?php
namespace SWServices\Validation;

use SWServices\Services as Services;
use SWServices\Validation\ValidateRequest as validateRequest;
use Exception;

class ValidaLco extends Services{
       
    public function __construct($params) {
        parent::__construct($params);
    }
    
   public static function Set($params){
        return new ValidaLco($params);
    }
    
    public static function ValidaLco($lco){
       return validateRequest::sendReqLco(Services::get_url(), Services::get_token(), $lco, Services::get_proxy());
    }   
}

?>