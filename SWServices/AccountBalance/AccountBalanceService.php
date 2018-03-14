<?php

namespace SWServices\AccountBalance;

use SWServices\AccountBalance\AccountBalanceRequest as ABR;
use Exception;


class AccountBalanceService {

    private static $_url = null;
    private static $_token = null;
    private static $_proxy = null;

    public function __construct($params) {
        if(!is_array($params)) { 
            throw new Exception('No tiene datos');
        }

        if(isset($params['url'])) {
            self::$_url = $params['url'];
        } else {
            throw new Exception('URL debe especificarse');
        }

        if(isset($params['token'])) {
            self::$_token = $params['token'];
        } else {
            throw new Exception('Datos de autenticación deben especificarse');
        }
        if(isset($params['proxy'])){
            self::$_proxy = $params['proxy'];
        }
    }

    public static function Set($params){
        return new AccountBalanceService($params);
        
    }
    
    public static function GetAccountBalance(){
        return ABR::sendReq(self::$_url, self::$_token, self::$_proxy);
    }
}
?>