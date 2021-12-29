<?php
namespace SWServices\Cancelation;

use SWServices\Cancelation\CancelationRequest as cancelationRequest;
use SWServices\Cancelation\CancelationHandler as cancelationHandler;
use SWServices\Services as Services;
use Exception;

class CancelationService extends Services {
        private static $_password = null;
        private static $_uuid = null;
        private static $_rfc = null;
        private static $_motivo = null;
        private static $_foliosustitucion= null;
        private static $_cerB64 = null;
        private static $_keyB64 = null;
        private static $_pfxB64 = null;

    public function __construct($params) {
        parent::__construct($params);
        if(isset($params['password'])){
            self::$_password = $params['password'];
        }
        if(isset($params['rfc'])){
            self::$_rfc = $params['rfc'];
        }
        if(isset($params['motivo'])){
            self::$_motivo = $params['motivo'];
        }
        if(isset($params['foliosustitucion'])){
            self::$_foliosustitucion = $params['foliosustitucion'];
        }
        if(isset($params['cerB64'])){
            self::$_cerB64 = $params['cerB64'];
        }
        if(isset($params['keyB64'])){
            self::$_keyB64 = $params['keyB64'];
        }
        if(isset($params['uuid'])){
            self::$_uuid = $params['uuid'];
        }
        if(isset($params['pfxB64'])){
            self::$_pfxB64 = $params['pfxB64'];
        }
    }
    
    public static function Set($params){
        return new CancelationService($params);
    }
        
    public static function CancelationByCSD() {
        return cancelationRequest::sendReqCSD(Services::get_url(), Services::get_token(),  cancelationHandler::uuidReq(self::$_uuid), self::$_password ,self::$_rfc, self::$_motivo, self::$_foliosustitucion, self::$_cerB64,self::$_keyB64,  Services::get_proxy(), '/cfdi33/cancel/csd');
    }

    public static function CancelationByXML($xml) {
        return cancelationRequest::sendReqXML(Services::get_url(), Services::get_token(), $xml, Services::get_proxy(), '/cfdi33/cancel/xml');
    }
    
    public static function CancelationByUUID(){
        return cancelationRequest::sendReqUUID(Services::get_url(), Services::get_token(), self::$_rfc, self::$_uuid, self::$_motivo, self::$_foliosustitucion, Services::get_proxy(), '/cfdi33/cancel/');
    }
    
    public static function CancelationByPFX(){
        return cancelationRequest::sendReqPFX(Services::get_url(), Services::get_token(),self::$_rfc, self::$_motivo, self::$_foliosustitucion, cancelationHandler::uuidReq(self::$_uuid), self::$_pfxB64, self::$_password,  Services::get_proxy(), '/cfdi33/cancel/pfx');
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
        
}
?>