<?php
namespace SWServices;
use SWServices\Authentication\AuthenticationService as Authentication;
use Exception;

    class Services {
        private static $_token = null;
        private static $_user = null;
        private static $_password = null;
        private static $_url = null;
        private static $_expirationDate = null;
        private static $_proxy = null;
        private static $_timeSession = "PT2H";

        public function __construct($params) {
            if(isset($params['url'])){
                self::$_url = $params['url'];
            }
            else{
                throw new Exception('URL debe especificarse');
            }
            if(!isset($params['user']) && !isset($params['password']) && !isset($params['token'])){
                throw new Exception('Datos de autenticación deben especificarse');
            }
            if(isset($params['user'])){
                self::$_user = $params['user'];
            }
            if(isset($params['password'])){
                self::$_password = $params['password'];
            }
            if(isset($params['proxy'])){
                self::$_proxy = $params['proxy'];
            }
            if(isset($params['token'])){
                self::$_token = $params['token'];
                date_default_timezone_set("America/Mexico_City");
                self::$_expirationDate = new \DateTime('NOW');
                self::$_expirationDate->add(new \DateInterval("P5Y"));
            }
        }
        
        public static function get_token(){

            if(self::$_token == null || new \DateTime('NOW') > self::$_expirationDate)
            {
                $params = array(
                    "url"=>self::$_url,
                    "user"=>self::$_user,
                    "password"=> self::$_password
                );

                $auth = Authentication::auth($params);
                $token = $auth::Token();
                if($token->status == "success"){
                    self::set_token($token->data->token);
                }
                else{
                    throw new Exception("Authentication error: $token->message Detail: $token->messageDetail");
                }
                date_default_timezone_set("America/Mexico_City");
                $_expirationDate = new \DateTime('NOW');
                $_expirationDate->add(new \DateInterval("P15Y"));
            }
            return  self::$_token;
        }

        public static function get_url(){
            return  self::$_url;
        }
        public static function get_user(){
            return  self::$_user;
        }
        public static function get_password(){
            return  self::$_password;
        }

        public static function set_token($token){
             self::$_token = $token;
        }
        public static function get_proxy(){
            return self::$_proxy;
        }
        
        
    };






?>
