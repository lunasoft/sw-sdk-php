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
        AR::sendReq($this->get_url(), $this->get_password(), $this->get_user());
    }
}










?>