<?php

namespace SWServices\Authentication;


use SWServices\Services as Services;
use SWServices\Authentication\AuthRequest as AR;


class AuthenticationService extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function auth($params){
        return new AuthenticationService($params);
    }
    

    public function Token(){
        return AR::sendReq(Services::get_url(), Services::get_password(), Services::get_user());
    }
}










?>