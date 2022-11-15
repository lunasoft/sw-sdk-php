<?php

namespace SWServices\Resend;

class ResendService extends ResendRequest {
    public function __construct($params)
    {
        parent::__construct($params);
    }
    public static function Set($params){
        return new ResendService($params);
    }
    public static function ResendEmail($uuid, $email){
        return ResendRequest::PostResendEmail($uuid, $email);
    }
}
?>