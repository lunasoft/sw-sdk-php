<?php

namespace SWServices\Cancelation;


use SWServices\Cancelation\CancelationRequest as cancelationRequest;
use Exception;

class CancelationService {
    private static $_cfdiData = null;
    private static $_url = null;
    private static $_token = null;
    private static $_xml = null;
    private static $_proxy = null;

    public function __construct($params) {
        $c = count($params);
        if($c == 7 || $c == 8)
            self::setCSD($params);
        else if ($c == 3 || $c == 4)
            self::setXml($params);
        
        else
           throw new Exception('Número de parámetros incompletos.');
    }

    public static function Set($params) {
        return new CancelationService($params);
    }

    public static function CancelationByCSD() {
        return cancelationRequest::sendReqCSD(self::$_url, self::$_token, self::$_cfdiData, self::$_proxy);
    }

    public static function CancelationByXML() {
        return cancelationRequest::sendReqXML(self::$_url, self::$_token, self::$_xml, $_proxy);
    }

    private static function setCSD($params) {
        if(isset($params['url']) && isset($params['token']) && isset($params['uuid']) && isset($params['password']) && isset($params['rfc']) && isset($params['b64Cer']) && isset($params['b64Key'])) {
            self::$_cfdiData = [
                'uuid'=> $params['uuid'],
                'password'=> $params['password'],
                'rfc'=> $params['rfc'],
                'b64Cer'=> $params['b64Cer'],
                'b64Key'=> $params['b64Key']
            ];
            self::$_url = $params['url'];
            self::$_token = $params['token'];
            if(isset($params['proxy'])){
                self::$_proxy = $params['proxy'];
            }
        } else {
            throw new Exception('Parámetros incompletos. Debe especificarse uuid, password, rfc, b64Cer, b64Key');
        }
    }

    private static function setXml($params) {
        if(isset($params['url']) && isset($params['token']) && isset($params['xml'])) {
            self::$_url = $params['url'];
            self::$_token = $params['token'];
            self::$_xml = $params['xml'];
            if(isset($params['proxy'])){
                self::$_proxy = $params['proxy'];
            }
        } else {
            throw new Exception('Parámetros incompletos. Debe especificarse url, token, y archivo xml');
        }
    }
}

?>