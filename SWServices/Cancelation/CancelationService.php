<?php
namespace SWServices\Cancelation;

use SWServices\Cancelation\CancelationRequest as cancelationRequest;
use SWServices\Cancelation\CancelationHandler as cancelationHandler;
use SWServices\Services as Services;
use Exception;

class CancelationService extends Services {
    private static $_cfdiData = null;
    private static $_xml = null;

    public function __construct($params) {
        parent::__construct($params);
        $c = count($params);
        if($c == 7 || $c == 8)
            self::setCSD($params);
        else if (($c == 3 || $c == 4) && isset($params['xml']))
            self::setXml($params);
    }
    
    public static function Set($params){
        return new CancelationService($params);
    }
        
    public static function CancelationByCSD($rfc, $cerB64, $keyB64, $password, $uuid) {
        return cancelationRequest::sendReqCSD(Services::get_url(), Services::get_token(), $rfc, cancelationHandler::uuidReq($uuid), $cerB64, $keyB64, $password, Services::get_proxy(), '/cfdi33/cancel/csd');
    }

    public static function CancelationByXML($xml) {
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy(), '/cfdi33/cancel/xml');
    }
    
    public static function CancelationByUUID($rfc, $uuid){
        return cancelationRequest::sendReqUUID(Services::get_url(), Services::get_token(), $rfc, $uuid, Services::get_proxy(), '/cfdi33/cancel/');
    }
    
    public static function CancelationByPFX($rfc, $pfxB64, $password, $uuid){
        return cancelationRequest::sendReqPFX(Services::get_url(), Services::get_token(), $rfc, cancelationHandler::uuidReq($uuid), $pfxB64, $password,  Services::get_proxy(), '/cfdi33/cancel/pfx');
    }
    
    public static function AceptarRechazarCancelacionPFX($rfc, $pfxB64, $password, $uuids){
        return cancelationRequest::sendReqPFX(Services::get_url(), Services::get_token(), $rfc, cancelationHandler::uuidsReq($uuids), $pfxB64, $password, Services::get_proxy(), '/acceptreject/pfx');
    }
    
    public static function AceptarRechazarCancelacionCSD($rfc, $cerB64, $keyB64, $password, $uuids){
       return cancelationRequest::sendReqCSD(Services::get_url(), Services::get_token(), $rfc, cancelationHandler::uuidsReq($uuids), $cerB64, $keyB64, $password, Services::get_proxy(), '/acceptreject/csd'); 
    }
    
    public static function AceptarRechazarCancelacionUUID($rfc, $uuid, $accion){
        return cancelationRequest::sendReqUUID(Services::get_url(), Services::get_token(), $rfc, $uuid, Services::get_proxy(), '/acceptreject/', $accion);
    }
    
    public static function AceptarRechazarCancelacionXML($xml){
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy(), '/acceptreject/xml');
    }
    
    public static function PendientesPorCancelar($rfc){
       return cancelationRequest::sendReqGet(Services::get_url(), Services::get_token(), $rfc, Services::get_proxy(), '/pendings/'); 
    }
    
    public static function ConsultarCFDIRelacionadosUUID($rfc, $uuid){
        return cancelationRequest::sendReqUUID(Services::get_url(), Services::get_token(), $rfc, $uuid, Services::get_proxy(), '/relations/');
    }
    
    public static function ConsultarCFDIRelacionadosCSD($rfc, $cerB64, $keyB64, $password, $uuid){
        return cancelationRequest::sendReqCSD(Services::get_url(), Services::get_token(), $rfc, cancelationHandler::uuidReq($uuid), $cerB64, $keyB64, $password, Services::get_proxy(), '/relations/csd');
    }
    
    public static function ConsultarCFDIRelacionadosPFX($rfc, $pfxB64, $password, $uuid){
        return cancelationRequest::sendReqPFX(Services::get_url(), Services::get_token(), $rfc, cancelationHandler::uuidReq($uuid), $pfxB64, $password, Services::get_proxy(), '/relations/pfx');
    }
    
    public static function ConsultarCFDIRelacionadosXML($xml){
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy(), '/relations/xml');
    }

    public static function CancelationByCSDParams() {
        return cancelationRequest::sendReqCSD(Services::get_url(), Services::get_token(), self::$_cfdiData["rfc"], cancelationHandler::uuidReq(self::$_cfdiData["uuid"]), self::$_cfdiData["b64Cer"], self::$_cfdiData["b64Key"], self::$_cfdiData["password"], Services::get_proxy(), '/cfdi33/cancel/csd');
    }
    public static function CancelationByXMLParams() {
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), self::$_xml, Services::get_proxy(), '/cfdi33/cancel/xml');
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
        } else {
            throw new Exception('Parámetros incompletos. Debe especificarse uuid, password, rfc, b64Cer, b64Key');
        }
    }
    private static function setXml($params) {
        if(isset($params['url']) && isset($params['token']) && isset($params['xml'])) {
            self::$_xml = $params['xml'];
        } else {
            throw new Exception('Parámetros incompletos. Debe especificarse url, token, y archivo xml');
        }
    }
        
}
?>