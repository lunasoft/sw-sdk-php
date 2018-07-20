<?php

namespace SWServices\AccountBalance;

use SWServices\AccountBalance\AccountBalanceRequest as accountBalanceRequest;
use SWServices\Services as Services;
use Exception;

class AccountBalanceService extends Services{
    public function __construct($params) {
        parent::__construct($params);
    }

    public static function Set($params){
        return new AccountBalanceService($params);
    }
    
    public static function GetAccountBalance(){
        return accountBalanceRequest::sendReq(Services::get_url(), Services::get_token(), Services::get_proxy());
    }
}
?>