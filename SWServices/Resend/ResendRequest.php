<?php

namespace SWServices\Resend;

use Exception;
use SWServices\Services;
use SWServices\Helpers\RequestHelper as HttpRequest;
use SWServices\Helpers\ResponseHelper as Response;

class ResendRequest extends Services {
    protected static function PostResendEmail($uuid, $email){
        try{
            if(!ResendRequest::ValidateParams($uuid, $email)){
                return Response::ToErrorResponse("El UUID o los correos no son válidos.");
            }
            $data = json_encode(array_merge(
                array(
                    "uuid"=>$uuid,
                    "to"=>$email
                ))
            );
            return HttpRequest::PostJson(Services::get_urlApi(), '/comprobante/resendemail', Services::get_token(), $data);
        }
        catch(Exception $e){
            return Response::ToErrorResponse($e->getMessage(), $e->getTraceAsString());
        }
    }
    private static function ValidateParams($uuid, $email){
        if(is_null($uuid) || is_null($email)){
            return false;
        }
        if(strpos($email, ',')){
            $arrayEmail = explode(',', $email);
            if(count($arrayEmail) > 5){
                return false;
            }
            for($i = 0; $i < count($arrayEmail); $i++){
             if(!filter_var($arrayEmail[$i], FILTER_VALIDATE_EMAIL)){
                return false;
             }
            }
        }else {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return false;
             }
        }
        return true;
    }
}
