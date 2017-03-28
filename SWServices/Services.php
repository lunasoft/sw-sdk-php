<?php
namespace SWServices;

     class Services {
        private static $_token = null;
        private  static $_user = null;
        private  static $_password = null;
        private static $_url = null;

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
            if(isset($params['token'])){
                self::$_token = $params['token'];
            }
           
                

        }
        
        public function get_token(){
            return  self::$_token;
        }

        public function get_url(){
            return  self::$_url;
        }
        public function get_user(){
            return  self::$_user;
        }
        public function get_password(){
            return  self::$_password;
        }

        public function set_token($token){
             self::$_token = $token;
        }
        
    };






?>