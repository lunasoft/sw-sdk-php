<?php
namespace SWServices\Validation;

use SWServices\Services as Services;
use SWServices\Validation\ValidateRequest as validateRequest;
use Exception;

class ValidaLrfc extends Services{
       
    public function __construct($params) {
        parent::__construct($params);
    }
    
   public static function Set($params){
        return new ValidaLrfc($params);
    }
    
    public static function ValidaLrfc($lrfc){
       return validateRequest::sendReqLrfc(Services::get_url(), Services::get_token(), $lrfc, Services::get_proxy());
    }  
}
?>