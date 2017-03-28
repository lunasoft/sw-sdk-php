<?php
namespace SWServices;

     class Services {
        private $_token = null;
        private  $_user = null;
        private  $_password = null;
        private $_url = null;

        public function __construct($params) {
            if(isset($params['url'])){
                $this->$_url = $params['url'];
            }
            else{
                throw new Exception('URL debe especificarse');
            }
            if(!isset($params['user']) && !isset($params['password']) && !isset($params['token'])){
                throw new Exception('Datos de autenticación deben especificarse');
            }
            if(isset($params['user'])){
                $this->$_user = $params['user'];
            }
            if(isset($params['password'])){
                $this->$_password = $params['password'];
            }
            if(isset($params['token'])){
                $this->$_token = $params['token'];
            }
           
                

        }
        
        public function get_token(){
            return  $this->$_token;
        }

        public function get_url(){
            return  $this->$_url;
        }
        public function get_user(){
            return  $this->$_user;
        }
        public function get_password(){
            return  $this->$_password;
        }

        public function set_token($token){
             $this->$_token = $token;
        }
        
    };






?>